<?php

namespace App\Jobs;

use App\Mail\Admin\TeamRecalculationConfirmation;
use App\Models\Fixture;
use App\Models\FixtureStats;
use App\Models\Season;
use App\Models\TeamPlayerContract;
use App\Models\TeamPlayerPoint;
use App\Models\TeamPoint;
use App\Services\TeamPlayerPointsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecalculatePointsForTeam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $team;
    public $email;
    public $teamPlayerPointsService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($team, $email)
    {
        $this->team = $team;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fixtures = Fixture::where('season_id', Season::getLatestSeason())->whereDate('date_time', '<=', now())->get();

        foreach ($fixtures as $fixture) {
            Log::info('Team id for getting team point: '.$this->team->id);
            Log::info('Fixture id for getting team point: '.$fixture->id);
            $teamPoint = TeamPoint::where('team_id', $this->team->id)->where('fixture_id', $fixture->id)->first();
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

        $contracts = TeamPlayerContract::select('player_id')->where('team_id', $this->team->id)->groupBy('player_id')->get();
        $teamPlayerPointsService = app(TeamPlayerPointsService::class);

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

                if ($teamPlayerContract && $teamPlayerContract->is_active) {

                    Log::info('TeamPlayerContract: '.$teamPlayerContract);
                    $fixStats = FixtureStats::where('fixture_id', $fixture->id)->where('player_id', $contract->player_id)->first();
                    if ($fixStats) {
                        $teamPlayerPointsService->updateLivePoints($fixStats, $this->team->id);
                        $teamPlayerPointsService->updateRankingPoints($fixStats, $this->team->id);
                    }
                }
            }
        }

        Mail::to($this->email)->send(new TeamRecalculationConfirmation($this->team));
    }
}
