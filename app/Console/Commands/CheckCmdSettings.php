<?php

namespace App\Console\Commands;

use App\Models\CmdSetting;
use App\Models\FixtureStats;
use App\Models\Team;
use Illuminate\Console\Command;

class CheckCmdSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:cmd-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run commands availabe to run in cmd_settings table';

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
        $commands = CmdSetting::all();
        if (count($commands) > 0) {
            info('Commands to execute :: '.count($commands));
        }
        $index = 1;
        foreach ($commands as $command) {
            info('loop iteration :: '.$index++);

            if ($command['type'] == 'recalculate_points') {
                $payload = json_decode($command['payload']);
                info('recalculate_points started for fixture stats :: '.$payload->fixture_stats);

                $fixtureStats = FixtureStats::find($payload->fixture_stats);

                if ($fixtureStats) {
                    info('FixtureStats found');
                    $this->call($command['command'], ['fixture_stats' => $fixtureStats]);
                }

                info('recalculate_points end for fixture stats :: '.$payload->fixture_stats);
            } elseif ($command['type'] == 'recalculate_points_for_team') {
                $payload = json_decode($command['payload']);
                info('recalculate_points_for_team started for team :: '.$payload->team);

                $team = Team::find($payload->team);
                $email = $payload->email;

                if ($team) {
                    info('Team found : Email :: '.$email);
                    $this->call($command['command'], ['team' => $team, 'email' => $email]);
                }

                info('recalculate_points_for_team end for fixture stats :: '.$payload->team);
            } elseif ($command['type'] == 'recalculate_points_for_league') {
                $payload = json_decode($command['payload']);
                info('recalculate_points_for_league started for league :: '.$payload->division);

                $division = $payload->division;
                $email = $payload->email;

                if ($division) {
                    info('Division found : Email :: '.$email);
                    $this->call($command['command'], ['division' => $division, 'email' => $email]);
                }

                info('recalculate_points_for_league end for division :: '.$payload->division);
            }

            $command->delete();
        }
    }
}
