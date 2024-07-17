<?php

namespace App\Console\Commands;

use App\Models\Club;
use App\Models\Fixture;
use App\Models\LogsFixtureData;
use App\Models\Season;
use App\Services\ClubService;
use App\Services\FixtureService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Sdapi\Endpoints\SdapiMatch;
use Sdapi\SdapiClient;

class ImportFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fixtures {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import fixtures from Gracenote API';

    /**
     * The FixtureService instance.
     *
     * @var FixtureService
     */
    protected $fixtureService;

    /**
     * The ClubService instance.
     *
     * @var ClubService
     */
    protected $clubService;

    /**
     * The HTTP client instance.
     *
     * @var SdapiClient
     */
    protected $client;

    /**
     * Create a new command instance.
     *
     * @param FixtureService $fixtureService
     * @param ClubService $clubService
     */
    public function __construct(FixtureService $fixtureService, ClubService $clubService)
    {
        parent::__construct();
        $this->fixtureService = $fixtureService;
        $this->clubService = $clubService;
        $this->client = new SdapiClient(config('fantasy.gracenote_outlet_auth_key'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting the fixtures import from Gracenote');

        $log = LogsFixtureData::begin();
        $dlt = $this->option('all') ? null : LogsFixtureData::deltaLastRunStartTime();

        $season = Season::find(Season::getLatestSeason());
        $tournaments = [
            ['id' => $season->premier_api_id, 'is_premier' => true],
            ['id' => $season->facup_api_id, 'is_premier' => false],
        ];

        $premierLeagueClubs = Club::premier()->pluck('id', 'api_id')->toArray();
        $existingClubApiIds = Club::pluck('id', 'api_id')->toArray();

        $existingFixtureApiIds = Fixture::where('season_id', $season->id)->pluck('id', 'api_id')->toArray();

        foreach ($tournaments as $key => $tournament) {
            $matches = $this->getMatchesByTournament($tournament['id'], $dlt);

            if ($matches && $matches->statusCode === 200) {
                $this->info('Found '.count($matches->match).' matches');

                foreach ($matches->match as $match) {
                    if (! isset($match->matchInfo->contestant)) {
                        continue;
                    }
                    // print_r($match->matchInfo->id);echo "\t";
                    // print_r($match->liveData->matchDetails->matchStatus);
                    // echo "\n";
                    // get home team
                    $home = Arr::first($match->matchInfo->contestant, function ($value) {
                        return strtolower($value->position) === 'home';
                    });

                    // get away team
                    $away = Arr::first($match->matchInfo->contestant, function ($value) {
                        return strtolower($value->position) === 'away';
                    });

                    // Skip if home or away team has not been decided.
                    if (! $home || ! $away) {
                        // $this->info('Skipping fixture as home or away team not yet decided.');
                        continue;
                    }

                    // Skip if both home team and away clubs are not in premier league.
                    if (! isset($premierLeagueClubs[$home->id]) && ! isset($premierLeagueClubs[$away->id])) {
                        // $this->info('SKIPPING...Home and Away club both are NOT premier league clubs '.$home->officialName.' '.$away->officialName);
                        continue;
                    }

                    // Skip if time is not decided
                    if (! $match->matchInfo->date || ! $match->matchInfo->time) {
                        // $this->info('SKIPPING...match date or time not found for fixture: '.$match->matchInfo->id);
                        continue;
                    }

                    // Skip if unrelated stage e.g preliminary round, qualifiying round etc. are not considered
                    if (! $stage = $this->formatTournamentStage($match->matchInfo->stage->name)) {
                        continue;
                    }

                    try {
                        $fixtureDateTime = Carbon::createFromFormat('Y-m-d\ZH:i:s\Z', $match->matchInfo->date.$match->matchInfo->time, 'UTC')->format(config('fantasy.db.datetime.format'));
                    } catch (\Exception $e) {
                        // $this->info('SKIPPING...invalid match date or time for fixture: '.$match->matchInfo->id);
                        continue;
                    }

                    if (isset($existingClubApiIds[$home->id])) {
                        $homeTeam = $existingClubApiIds[$home->id];
                    } else {
                        // $this->info('Home club does NOT exists '.$home->officialName);

                        // club not found, create a new one
                        $homeTeamRecord = $this->clubService->create([
                            'name' => $home->officialName,
                            'api_id' => $home->id,
                            'short_name' => $home->name,
                            'short_code' => isset($home->code) ? $home->code : '',
                        ]);

                        // $this->info('Home club created with ID '.$homeTeamRecord->id);
                        $homeTeam = $homeTeamRecord->id;
                        $existingClubApiIds[$home->id] = $homeTeamRecord->id;
                    }

                    if (isset($existingClubApiIds[$away->id])) {
                        $awayTeam = $existingClubApiIds[$away->id];
                    } else {
                        // $this->info('Away club does NOT exists '.$away->officialName);
                        // club not found
                        $awayTeamRecord = $this->clubService->create([
                            'name' => $away->officialName,
                            'api_id' => $away->id,
                            'short_name' => $away->name,
                            'short_code' => isset($away->code) ? $away->code : '',
                        ]);

                        // $this->info('Away club created with ID '.$awayTeamRecord->id);
                        $awayTeam = $awayTeamRecord->id;
                        $existingClubApiIds[$awayTeam] = $awayTeamRecord->id;
                    }

                    $fixture = Fixture::firstOrNew(['api_id' => $match->matchInfo->id]);
                    $fixture->season_id = $season->id;
                    $fixture->competition = $match->matchInfo->competition->name;
                    $fixture->home_club_id = $homeTeam;
                    $fixture->away_club_id = $awayTeam;
                    $fixture->api_id = $match->matchInfo->id;
                    $fixture->date_time = $fixtureDateTime;
                    $fixture->status = $match->liveData->matchDetails->matchStatus;
                    $fixture->stage = $stage;
                    $fixture->outcome = isset($match->liveData->matchDetails->winner) ? strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) : null;
                    $fixture->home_score = isset($match->liveData->matchDetails->scores->total->home) ? $match->liveData->matchDetails->scores->total->home : null;
                    $fixture->away_score = isset($match->liveData->matchDetails->scores->total->away) ? $match->liveData->matchDetails->scores->total->away : null;
                    $fixture->ht_home_score = isset($match->liveData->matchDetails->scores->ht->home) ? $match->liveData->matchDetails->scores->ht->home : null;
                    $fixture->ht_away_score = isset($match->liveData->matchDetails->scores->ht->away) ? $match->liveData->matchDetails->scores->ht->away : null;
                    $fixture->ft_home_score = isset($match->liveData->matchDetails->scores->ft->home) ? $match->liveData->matchDetails->scores->ft->home : null;
                    $fixture->ft_away_score = isset($match->liveData->matchDetails->scores->ft->away) ? $match->liveData->matchDetails->scores->ft->away : null;
                    if (isset($match->liveData->matchDetails->winner)) {
                        if (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'H') {
                            $fixture->winner = $homeTeam;
                        } elseif (strtoupper(substr($match->liveData->matchDetails->winner, 0, 1)) == 'A') {
                            $fixture->winner = $awayTeam;
                        }
                    }
                    $fixture->save();
                }
            }
        }

        $log->end();

        $this->info('End process import fixtures jobs...');
    }

    public function getMatchesByTournament($id, $dlt = null)
    {
        try {
            return (new SdapiMatch($this->client))->getMatchesByTournament($id, $dlt, true);
        } catch (\Exception $e) {
            return;
        }
    }

    public function formatTournamentStage($stage)
    {
        $roundMapping = [
            'Regular Season' => 'Regular Season',
            '3rd Round' => '3rd Round',
            '3rd Round Replays' => '3rd Round',
            '4th Round' => '4th Round',
            '4th Round Replays' => '4th Round',
            '5th Round' => '5th Round',
            '5th Round Replays' => '5th Round',
            'Quarter-finals' => 'Quarter-finals',
            'Semi-finals' => 'Semi-finals',
            'Final' => 'Final',
        ];

        return Arr::get($roundMapping, $stage, false);
    }
}
