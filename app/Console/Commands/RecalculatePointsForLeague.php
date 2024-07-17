<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\TeamPoint;
use App\Models\Fixture;
use App\Models\Season;
use App\Models\FixtureStats;
use Illuminate\Console\Command;
use App\Models\TeamPlayerPoint;
use Illuminate\Support\Facades\Log;
use App\Models\TeamPlayerContract;
use Illuminate\Support\Facades\Mail;
use App\Services\TeamPlayerPointsService;
use App\Mail\Admin\LeagueRecalculationConfirmation;

class RecalculatePointsForLeague extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:league-points {division} {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to recalculate division all teams players points';

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
        $this->info('Start League Points Recalculate '. now());

        $division = $this->argument('division');
        $email = $this->argument('email');

        $season = Season::find(Season::getLatestSeason());

        if($division) {

            $division = Division::find($division)->load('divisionTeams');

            //Create Additional Contract form season start date
            foreach ($division->divisionTeams as $team) {

                $team->load('transfer');

                foreach ($team->teamPlayerContracts()->orderBy('start_date')->get()->groupBy('player_id') as $contracts) {
                    if($contracts) {

                        $contract = $contracts->first();
                        if($team->transfer->where('player_in', $contract->player_id)->where('transfer_type','auction')->count()) {

                            $seasonStart = $season->start_at;
                            $contractStart = Carbon::parse($contract->start_date);
                            $diff = $seasonStart->diffInDays($contractStart);

                            if($diff > 0) {
                                $newContract = TeamPlayerContract::create([
                                    'team_id' => $contract->team_id,
                                    'player_id' => $contract->player_id,
                                    'start_date' => $seasonStart,
                                    'end_date' => $contractStart,
                                    'is_active' => true,
                                ]);

                                info('Created new team player contract '.$newContract);
                                $this->info('Created new contract for => '.$contract->team_id.' '.$contract->player_id);
                            }
                        }
                    }
                }
            }

            $fixtures = Fixture::where('season_id', $season->id)->whereDate('date_time', '<=', now())->get();

            $teamPlayerPointsService = app(TeamPlayerPointsService::class);

            foreach ($division->divisionTeams as $team) {

                $this->info('Start For Team => '.$team->id.' - '.$team->name);

                foreach ($fixtures as $fixture) {
                    $teamPoint = TeamPoint::where('team_id', $team->id)->where('fixture_id', $fixture->id)->first();
                    if ($teamPoint) {
                        $teamPlayerPoints = TeamPlayerPoint::where('team_id', $team->id)->where('team_point_id', $teamPoint->id)->get();
                        foreach ($teamPlayerPoints as $teamPlayerPoint) {
                            $teamPlayerPoint->delete();
                        }
                        $teamPoint->delete();
                    }
                }

                $contracts = TeamPlayerContract::select('player_id')->where('team_id', $team->id)->groupBy('player_id')->get();

                foreach ($contracts as $contract) {
                    foreach ($fixtures as $fixture) {
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

                        if ($teamPlayerContract && $teamPlayerContract->is_active) {

                            $fixStats = FixtureStats::where('fixture_id', $fixture->id)->where('player_id', $contract->player_id)->first();
                            if ($fixStats) {
                                $teamPlayerPointsService->updateLivePoints($fixStats, $team->id);
                                $teamPlayerPointsService->updateRankingPoints($fixStats, $team->id);
                            }
                        }
                    }
                }
            }

            $this->info('End League Points Recalculate '. now());

            if($email) {
                Mail::to($division->consumer->user->email)->bcc($email)->send(new LeagueRecalculationConfirmation($division));
            } else {
                Mail::to($division->consumer->user->email)->send(new LeagueRecalculationConfirmation($division));
            }
        }
    }
}
