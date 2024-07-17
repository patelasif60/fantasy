<?php

namespace App\Console\Commands;

use App\Mail\Admin\SuperSubInvalidTeamsReport;
use App\Models\Division;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InvalidSuperSubTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:invalid-supersub-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Script to pre-determine the teams that will become invalid as Supersubs are applied in the future';

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
        $file = storage_path('/reports/teams/invalid/invalid-supersub-teams-report-'.date('Ymd').'.csv');
        $handle = fopen($file, 'w');
        fputcsv($handle, [
            'Team ID', 'League ID', 'Default squad size',
            'Lineup players', 'Substitue players', 'Total players', 'Fixture DateTime', 'Auction close date', 'Manager email', 'Result',
        ]);

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
                            fputcsv($handle, [
                                $team->id, $division->id, $defaultSquadSize,
                                $lineup, $subs, $total, carbon_format_to_datetime_for_fixture($start_date), carbon_format_to_datetime_for_fixture($division->auction_closing_date), $managerEmail, $op,
                            ]);
                        }
                    } else {
                        if ($division->auction_closing_date === null) {
                            $op = 'NOT SET - AUCTION NOT CLOSED';
                        } else {
                            $op = 'INVALID';
                            fputcsv($handle, [
                                $team->id, $division->id, $defaultSquadSize,
                                $lineup, $subs, $total, carbon_format_to_datetime_for_fixture($start_date), carbon_format_to_datetime_for_fixture($division->auction_closing_date), $managerEmail, $op,
                            ]);
                        }
                    }
                }

                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }

        fclose($handle);
        \Mail::to(config('fantasy.report.emails'))->send(new SuperSubInvalidTeamsReport($file));
        $this->info('All done');
    }
}
