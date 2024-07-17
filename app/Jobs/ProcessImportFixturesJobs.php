<?php

namespace App\Jobs;

use App\Models\Club;
use App\Models\Fixture;
use App\Models\LogsFixtureData;
use App\Models\Season;
use App\Services\ClubService;
use App\Services\FixtureService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sdapi\Endpoints\SdapiMatch;
use Sdapi\Endpoints\SdapiTournamentCalendar;
use Sdapi\SdapiClient;

class ProcessImportFixturesJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Start process import fixtures jobs...');

        $fixtureLog['start_time'] = now();
        $fixtureLog['status'] = 'started';
        $fixtureLog['end_time'] = null;
        $fixtureLogData = $this->fixtureInsertLog($fixtureLog);

        $log = LogsFixtureData::find(LogsFixtureData::getLatestFixtureLog());
        $dlt = null;
        if ($log) {
            $dlt = str_replace('+00:00', 'Z', gmdate('c', strtotime($log->start_time)));
        }

        $season = Season::find(Season::getLatestSeason());
        $seasons = [
            ['id' => $season->premier_api_id, 'is_premier' => true],
            ['id' => $season->facup_api_id, 'is_premier' => false],
        ];

        $clubService = app(ClubService::class);
        $fixtureService = app(FixtureService::class);

        $existingClubApiIds = Club::pluck('id', 'api_id')->toArray();
        $existingFixtureApiIds = Fixture::where('season_id', $season->id)->pluck('id', 'api_id')->toArray();

        foreach ($seasons as $key => $seasonData) {
            $matches = $this->getMatchesByTournament($seasonData['id'], $dlt);

            if ($matches->statusCode === 200) {
                foreach ($matches->match as $match) {
                    $homeClubData = [
                        'name' => $match->matchInfo->contestant[0]->officialName,
                        'api_id' => $match->matchInfo->contestant[0]->id,
                        'short_name' => $match->matchInfo->contestant[0]->name,
                        'short_code' => isset($match->matchInfo->contestant[1]->code) ? $match->matchInfo->contestant[0]->code : '',
                        'is_premier' => $seasonData['is_premier'],
                    ];

                    $awayClubData = [
                        'name' => $match->matchInfo->contestant[1]->officialName,
                        'api_id' => $match->matchInfo->contestant[1]->id,
                        'short_name' => $match->matchInfo->contestant[1]->name,
                        'short_code' => isset($match->matchInfo->contestant[1]->code) ? $match->matchInfo->contestant[1]->code : '',
                        'is_premier' => $seasonData['is_premier'],
                    ];

                    $homeApiId = $match->matchInfo->contestant[0]->id;
                    if (isset($existingClubApiIds[$homeApiId])) {
                        $homeTeam = $existingClubApiIds[$homeApiId];
                    } else {
                        $home = $clubService->create($homeClubData);
                        $homeTeam = $home->id;
                        $existingClubApiIds[$homeApiId] = $homeTeam;
                    }

                    $awayApiId = $match->matchInfo->contestant[1]->id;
                    if (isset($existingClubApiIds[$awayApiId])) {
                        $awayTeam = $existingClubApiIds[$awayApiId];
                    } else {
                        $away = $clubService->create($awayClubData);
                        $awayTeam = $away->id;
                        $existingClubApiIds[$awayApiId] = $awayTeam;
                    }

                    $fixtureDateTime = Carbon::createFromFormat('Y-m-d\ZH:i:s\Z', $match->matchInfo->date.$match->matchInfo->time, 'UTC')->format('d/m/Y H:i:s');

                    $data = [
                        'season' => $season->id,
                        'competition' => $match->matchInfo->competition->name,
                        'home_club' => $homeTeam,
                        'away_club' => $awayTeam,
                        'api_id' => $match->matchInfo->id,
                        'date_time' => $fixtureDateTime,
                    ];

                    $matchApiId = $match->matchInfo->id;
                    if (isset($existingFixtureApiIds[$matchApiId])) {
                        $fixtureId = $existingFixtureApiIds[$match->matchInfo->id];
                        $fixture = Fixture::find($fixtureId);
                        $fixtureService->update($fixture, $data);
                    } else {
                        $fixtureInsertData = $fixtureService->create($data);
                        $existingFixtureApiIds[$matchApiId] = $fixtureInsertData->id;
                    }
                }
            }
        }

        $fixtureLog = [];
        $fixtureLog['end_time'] = now();
        $fixtureLog['status'] = 'completed';
        $this->fixtureUpdateLog($fixtureLogData, $fixtureLog);

        info('End process import fixtures jobs...');
    }

    public function getClient()
    {
        return new SdapiClient(config('fantasy.gracenote_outlet_auth_key'));
    }

    public function getTournamentByCompetition($id)
    {
        $client = $this->getClient();
        $matchQuery = new SdapiTournamentCalendar($client);

        return $matchQuery->getTournamentByCompetition($id);
    }

    public function getMatchesByTournament($id)
    {
        $client = $this->getClient();
        $matchQuery = new SdapiMatch($client);

        return $matchQuery->getMatchesByTournament($id);
    }

    public function fixtureInsertLog($data)
    {
        $log = LogsFixtureData::create([
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'status' => $data['status'],
        ]);

        return $log;
    }

    public function fixtureUpdateLog($fixtureLogData, $data)
    {
        $fixtureLogData = $fixtureLogData->fill([
            'end_time' => $data['end_time'],
            'status' => $data['status'],
        ]);

        $fixtureLogData->save();

        return $fixtureLogData;
    }
}
