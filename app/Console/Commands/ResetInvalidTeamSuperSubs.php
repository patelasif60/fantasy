<?php

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class ResetInvalidTeamSuperSubs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:invalid-team-supersubs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets all supersubs of invalid teams';

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
        Log::info('********* RESET SUPERSUBS START *********');

        $futureFixtureDates = SupersubTeamPlayerContract::where('start_date', '>=', Carbon::now())
                                                    ->distinct()->select('start_date')
                                                    ->get();

        foreach ($futureFixtureDates as $key => $fixtureDate) {
            $start_date = Carbon::parse($fixtureDate->start_date)->format('Y-m-d H:i:s');

            $teams = SupersubTeamPlayerContract::where('start_date', $start_date)
                                                    ->where('is_applied', 0)
                                                    ->selectRaw('team_id, COUNT(IF(is_active = 1, 1 , NULL)) AS lineup, COUNT(IF(is_active = 0, 1 , NULL)) AS subs')
                                                    ->groupBy('team_id')
                                                    ->get();

            $this->info('Supersub date : '.$start_date.' | Count of Teams : '.count($teams));

            $this->output->progressStart(count($teams));
            foreach ($teams as $key => $teamSuperSub) {
                $team = Team::find($teamSuperSub->team_id);
                $division = Division::find($team->divisionTeam->division_id);

                $managerEmail = $team->consumer->user->email;
                $defaultSquadSize = $division->getOptionValue('default_squad_size');

                $lineup = $teamSuperSub->lineup;
                $subs = $teamSuperSub->subs;

                $total = $lineup + $subs;

                if ($total === 0) {
                    $op = 'NOT SET';
                } else {
                    if ($total == $defaultSquadSize) {
                        if ($lineup == 11) {
                            $op = 'VALID';
                        } else {
                            $op = 'INVALID';
                            Log::info('Resets supersubs for TeamID: '.$team->id.' and StartDate: '.$start_date);
                            $affectedRows = SupersubTeamPlayerContract::where('start_date', $start_date)
                                                    ->where('team_id', $team->id)
                                                    ->update(['is_applied' => true]);
                            Log::info('Affected records: '.$affectedRows);
                        }
                    } else {
                        if ($division->auction_closing_date === null) {
                            $op = 'NOT SET - AUCTION NOT CLOSED';
                        } else {
                            $op = 'INVALID';
                            Log::info('Resets supersubs for TeamID: '.$team->id.' and StartDate: '.$start_date);
                            $affectedRows = SupersubTeamPlayerContract::where('start_date', $start_date)
                                                    ->where('team_id', $team->id)
                                                    ->update(['is_applied' => true]);
                            Log::info('Affected records: '.$affectedRows);
                        }
                    }
                }

                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }
        $this->info('All done');
        Log::info('********* RESET SUPERSUBS END *********');
    }
}
