<?php

namespace App\Console\Commands;

use App\Mail\Admin\SquadSizeReportGenerated;
use App\Models\Season;
use Illuminate\Console\Command;

class GenerateInvalidFormationTeamReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:invalid-formation-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a report with all invalid formation teams in the database.';

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
        if (config('fantasy.is_production') != 'true') {
            return false;
        }

        $season = Season::getLatestSeason();
        $repo = app(\App\Repositories\TeamLineupRepository::class);
        $auctionService = app(\App\Services\AuctionService::class);
        $transferService = app(\App\Services\TransferService::class);
        $teamPlayerRepository = app(\App\Repositories\TeamPlayerRepository::class);
        $validateTransferFormationService = app(\App\Services\ValidateTransferFormationService::class);
        $date = now()->format(config('fantasy.db.datetime.format'));

        $teams = \DB::select("select team_id, division_id from teams inner join division_teams dt on dt.team_id = teams.id and dt.season_id = $season inner join divisions d on d.id = dt.`division_id` where teams.is_approved = 1");

        $file = storage_path('/reports/teams/invalid/invalid-teams-formation-report-'.date('YmdHis').'.csv');
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
                        $op = 'INVALID-FORMATION';

                        $mergeDefenders = $division->getOptionValue('merge_defenders');
                        $availableFormations = $division->getOptionValue('available_formations');
                        $activePlayers = $transferService->getActiveTeamPlayerPositionReport($team);
                        if (! $validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $activePlayers)) {
                            fputcsv($handle, [
                                $team->id, $team_id->division_id, $defaultSquadSize,
                                $lineup, $subs, $total, $managerEmail, $op,
                            ]);
                        }
                    } else {
                        if ($division->auction_closing_date === null) {
                            $op = 'NOT SET - AUCTION NOT CLOSED';
                        } else {
                            $op = 'INVALID-LINEUP-BENCH';

                            fputcsv($handle, [
                                $team->id, $team_id->division_id, $defaultSquadSize,
                                $lineup, $subs, $total, $managerEmail, $op,
                            ]);
                        }
                    }
                } else {
                    if ($division->auction_closing_date === null) {
                        $op = 'NOT SET - AUCTION NOT CLOSED';
                    } else {
                        $op = 'INVALID-SIZE';

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
