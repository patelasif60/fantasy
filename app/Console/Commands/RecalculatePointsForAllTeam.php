<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\FixtureStats;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPlayerPointDefault;
use App\Models\TeamPoint;
use App\Models\TeamPointDefault;
use App\Services\TeamPlayerPointsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecalculatePointsForAllTeam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:points-all-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to recalculate All teams and its player points based on fixture and player list';

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
        $teams = Team::where('is_approved', true)->get();
        //$teams = Team::where('id', 3)->get();
        $fixtures = Fixture::where('season_id', Season::getLatestSeason())
        ->whereDate('date_time', '<=', now())
        ->get();

        $this->info('Start Points Calculation');
        Log::info('Start Points Calculation');
        foreach ($teams as $key => $team) {
            $this->info('Start Points Calculation of Team: '.$team->id);
            Log::info('Start Points Calculation of Team: '.$team->id);
            Log::info('Fixtures: '.$fixtures);
            $contracts = TeamPlayerContract::select('player_id')
                        ->where('team_id', $team->id)
                        ->groupBy('player_id')
                        ->get();
            Log::info('TeamPlayerContract: '.$contracts);
            foreach ($fixtures as $fixture) {

                // $teamPoint = TeamPoint::where('team_id', $team->id)->where('fixture_id', $fixture->id)->first();

                // if ($teamPoint) {
                //     $teamPlayerPoint = TeamPlayerPoint::where('team_id', $team->id)->where('team_point_id', $teamPoint->id)->first();
                //     Log::info('Team player point to be deleted: '.$teamPlayerPoint);
                //     if($teamPlayerPoint){
                //         $teamPlayerPoint->delete();
                //     }

                //     Log::info('Team point to be deleted: '.$teamPoint);
                //     $teamPoint->delete();
                // }

                $teamPointDefault = TeamPointDefault::where('team_id', $team->id)->where('fixture_id', $fixture->id)->first();
                if ($teamPointDefault) {
                    $teamPlayerPointDefault = TeamPlayerPointDefault::where('team_id', $team->id)->where('team_point_default_id', $teamPointDefault->id)->first();
                    Log::info('Team player point to be deleted: '.$teamPlayerPointDefault);
                    if ($teamPlayerPointDefault) {
                        $teamPlayerPointDefault->delete();
                    }
                    Log::info('Team point to be deleted: '.$teamPointDefault);
                    $teamPointDefault->delete();
                }
            }

            foreach ($contracts as $contract) {
                foreach ($fixtures as $fixture) {
                    Log::info('Fixture id: '.$fixture->id);
                    Log::info('Player id: '.$contract->player_id);
                    $teamPlayerContract = TeamPlayerContract::where('team_id', $team->id)
                                            ->where('player_id', $contract->player_id)
                                            ->where(function ($q) use ($fixture) {
                                                $q->where(function ($query) use ($fixture) {
                                                    $query->where('start_date', '<=', $fixture->date_time)
                                                          ->where('end_date', '>', $fixture->date_time);
                                                })
                                                  ->orWhere(function ($query) use ($fixture) {
                                                      $query->where('start_date', '<=', $fixture->date_time)
                                                              ->whereNull('end_date');
                                                  });
                                            })->first();
                    Log::info('$teamPlayerContract: '.$teamPlayerContract);
                    if ($teamPlayerContract && $teamPlayerContract->is_active) {
                        $fixStats = FixtureStats::where('fixture_id', $fixture->id)->where('player_id', $contract->player_id)->first();
                        Log::info('FixtureStats: '.$fixStats);
                        if ($fixStats) {
                            $teamPlayerPointsService = app(TeamPlayerPointsService::class);
                            //$teamPlayerPointsService->updateLivePoints($fixStats, $team->id);
                            $teamPlayerPointsService->updateRankingPoints($fixStats, $team->id);
                            Log::info('Recalculation done for: '.$fixStats);
                        }
                    }
                }
            }

            $this->info('Finish Points Calculation Point of Team: '.$team->id);
            Log::info('Finish Points Calculation Point of Team: '.$team->id);
        }

        $this->info('Finish Points Calculation');
        Log::info('Finish Points Calculation');
    }
}
