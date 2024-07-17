<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Division;
use App\Models\DivisionTeam;
use Illuminate\Console\Command;
use App\Services\DivisionService;
use App\Models\HeadToHeadFixture;
use App\Models\HeadToHeadCalendar;
use Illuminate\Support\Facades\DB;

class GenerateHeadToHeadFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'head-to-head-fixtures:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate the head-to-head fixtures between teams of each leagues.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        // get current season
        $season = Season::getLatestSeason();

        $divisionsIds = DivisionTeam::where('season_id', $season)
                        ->groupBy('division_id')
                        ->pluck('division_id')
                        ->toArray();
        $now = now();

        $leagues = Division::whereHas('divisionTeams', function ($query) use ($season, $now) {
            $query->where('season_id', $season);
        })->whereIn('id',$divisionsIds)->get();

        // for each leagues in current season, generate head-to-head fixtures as per the calendar and league size
        $leagues->each(function ($league) use ($season, $now) {
            $size = $league->divisionTeamsCurrentSeason()->approve()->count();
            if($size == 5 || $size == 6 || $size == 7 || $size == 8|| $size == 11 || $size == 12) {

                $this->info("league id {$league->id}");
                $links = $league->divisionTeams->pluck('id')->toArray();
                $isExist = HeadToHeadFixture::where('season_id',$season)
                                    ->whereIn('home_team_id',$links)
                                    ->orwhereIn('away_team_id',$links)
                                    ->count();

                if($isExist == 0) {

                    $adjustedSize = app(DivisionService::class)->adjustSize($size);
                    $this->info("size {$size}");
                    $this->info("season id {$season}");
                    $calendarFixtures = HeadToHeadCalendar::select([
                        'home_team.id as home_team_id',
                        'away_team.id as away_team_id',
                        'league_phases.id as league_phase_id',
                    ])
                        ->join('division_teams as home_division_team', 'home_division_team.number', '=', 'head_to_head_calendar.home_team_number')
                        ->join('teams as home_team', 'home_team.id', '=', 'home_division_team.team_id')
                        ->join('division_teams as away_division_team', 'away_division_team.number', '=', 'head_to_head_calendar.away_team_number')
                        ->join('teams as away_team', 'away_team.id', '=', 'away_division_team.team_id')
                        ->join('league_phases', function ($join) use ($adjustedSize) {
                            $join->on('league_phases.name', '=', DB::raw('CONCAT("Phase ", head_to_head_calendar.number)'))
                                ->where('league_phases.size', '=', $adjustedSize);
                        })
                        ->join('gameweeks', function ($join) use ($season) {
                            $join->on('gameweeks.id', '=', 'league_phases.gameweek_id')
                            ->where('gameweeks.season_id', '=', $season);
                        })
                        ->where('home_division_team.season_id', '=', $season)
                        ->where('away_division_team.season_id', '=', $season)
                        ->where('home_division_team.division_id', '=', $league->id)
                        ->where('away_division_team.division_id', '=', $league->id)
                        ->where('head_to_head_calendar.size', '=', $size)
                        ->get();

                    $calendarFixtures->map(function ($fixture) use ($season, $now) {
                        $fixture['season_id'] = $season;
                        $fixture['status'] = 'Fixture';
                        $fixture['created_at'] = $now;
                        $fixture['updated_at'] = $now;

                        return $fixture;
                    });

                    $this->info('count '.$calendarFixtures->count());
                    HeadToHeadFixture::insert($calendarFixtures->toArray());
                } else {
                    info('Already generated fixtures => '.$league->id);
                    info($links);
                }
            }
        });

        $this->info('Process complete.');
    }
}
