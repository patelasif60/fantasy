<?php

namespace App\Console\Commands;

use App\Mail\Admin\SquadSizeReportGenerated;
use Illuminate\Console\Command;

class GenerateInvalidTeamsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:invalid-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a report with all invalid teams in the database.';

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
        $repo = app(\App\Repositories\TeamLineupRepository::class);
        $teams = \DB::select('select team_id, division_id from teams inner join division_teams dt on dt.team_id = teams.id and dt.season_id = 30 inner join divisions d on d.id = dt.`division_id` where teams.is_approved = 1');

        $file = storage_path('/reports/teams/invalid/invalid-teams-report-'.date('YmdHis').'.csv');
        $handle = fopen($file, 'w');
        fputcsv($handle, [
            'Team ID', 'League ID', 'Default squad size',
            'Lineup players', 'Substitue players', 'Total players', 'Manager email', 'Result',
        ]);

        $this->output->progressStart(count($teams));
        foreach ($teams as $key => $team_id) {
            $team = \App\Models\Team::find($team_id->team_id);

            if (! $team) {
                continue;
            }

            $division = \App\Models\Division::find($team_id->division_id);

            if ($division->auction_closing_date === null) {
                continue;
            }

            $lineup = $repo->getPlayers($team, 'active', false)->count();
            $subs = $repo->getPlayers($team, 'sub', false)->count();
            $total = $lineup + $subs;
            $managerEmail = $team->consumer->user->email;
            $defaultSquadSize = $division->getOptionValue('default_squad_size');
            if ($total === 0) {
                $op = 'NOT SET';
            } else {
                if ($total === $defaultSquadSize) {
                    if ($lineup == 11) {
                        $op = 'VALID';
                    } else {
                        $op = 'INVALID';
                        $tpc = \DB::select("select count(*) as c from team_player_contracts where team_id = $team->id and end_date is null");

                        fputcsv($handle, [
                            $team->id, $team_id->division_id, $defaultSquadSize,
                            $lineup, $subs, $total, $managerEmail, $op,
                        ]);
                    }
                } else {
                    // check auction complete or not
                    if ($division->auction_closing_date === null) {
                        $op = 'NOT SET - AUCTION NOT CLOSED';
                    } else {
                        $op = 'INVALID';
                        $tpc = \DB::select("select count(*) as c from team_player_contracts where team_id = $team->id and end_date is null");

                        fputcsv($handle, [
                            $team->id, $team_id->division_id, $defaultSquadSize,
                            $lineup, $subs, $total, $managerEmail, $op,
                        ]);
                    }
                }
            }

            $this->output->progressAdvance();
        }
        fclose($handle);
        $this->output->progressFinish();
        \Mail::to(config('fantasy.report.emails'))->send(new SquadSizeReportGenerated($file));
        $this->info('done');
    }
}
