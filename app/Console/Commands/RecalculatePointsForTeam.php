<?php

namespace App\Console\Commands;

use App\Mail\Admin\TeamRecalculationConfirmation;
use App\Models\Fixture;
use App\Models\FixtureStats;
use App\Models\Season;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPoint;
use App\Services\TeamPlayerPointsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecalculatePointsForTeam extends Command
{
    protected $team;
    protected $email;
    protected $teamPlayerPointsService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:points-for-team {team} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will recalculate single team point and its player points based on fixture and player list';

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
        $this->team = $this->argument('team');
        $this->email = $this->argument('email');

        $fixtures = Fixture::where('season_id', Season::getLatestSeason())
        ->whereDate('date_time', '<=', now())
        ->get();

        //Log::info('Fixtures: '.$fixtures);
        $contracts = TeamPlayerContract::select('player_id')
                        ->where('team_id', $this->team->id)
                        ->groupBy('player_id')
                        ->get();
        //Log::info('TeamPlayerContract: '.$contracts);
        foreach ($fixtures as $fixture) {
            Log::info('Team id for getting team point: '.$this->team->id);
            Log::info('Fixture id for getting team point: '.$fixture->id);
            $teamPoint = TeamPoint::where('team_id', $this->team->id)->where('fixture_id', $fixture->id)->first();
            Log::info('Team point: '.$teamPoint);
            if ($teamPoint) {
                $teamPlayerPoints = TeamPlayerPoint::where('team_id', $this->team->id)->where('team_point_id', $teamPoint->id)->get();
                foreach ($teamPlayerPoints as $teamPlayerPoint) {
                    Log::info('Team player point to be deleted: '.$teamPlayerPoint);
                    $teamPlayerPoint->delete();
                }
                Log::info('Team point to be deleted: '.$teamPoint);
                $teamPoint->delete();
            }
        }

        foreach ($contracts as $contract) {
            foreach ($fixtures as $fixture) {
                Log::info('Fixture id: '.$fixture->id);
                Log::info('Player id: '.$contract->player_id);
                $teamPlayerContract = TeamPlayerContract::where('team_id', $this->team->id)
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
                    //Log::info('FixtureStats: '.$fixStats);
                    if ($fixStats) {
                        $teamPlayerPointsService = app(TeamPlayerPointsService::class);
                        $teamPlayerPointsService->updateLivePoints($fixStats, $this->team->id);
                        $teamPlayerPointsService->updateRankingPoints($fixStats, $this->team->id);
                        //Log::info('Recalculation done for: '.$fixStats);
                    }
                }
            }
        }
        Mail::to($this->email)
            ->send(new TeamRecalculationConfirmation($this->team));
    }
}
