<?php

namespace App\Console\Commands;

use App\Models\Division;
use App\Models\SupersubTeamPlayerContract;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class CleanSuperSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:supersub-duplicate-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes duplicate records of supersubs for teams';

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
            Log::info('Supersub date : '.$start_date.' | Count of Teams : '.count($teams));

            $this->output->progressStart(count($teams));
            foreach ($teams as $key => $teamSuperSub) {
                Log::info('TeamID : '.$teamSuperSub->team_id);

                $team = Team::find($teamSuperSub->team_id);
                $division = Division::find($team->divisionTeam->division_id);
                $defaultSquadSize = $division->getOptionValue('default_squad_size');

                $lineup = $teamSuperSub->lineup;
                $subs = $teamSuperSub->subs;

                $total = $lineup + $subs;

                if ($total > $defaultSquadSize) {
                    Log::info('Total : '.$total.' | Default squad size : '.$defaultSquadSize);

                    $ssContracts = SupersubTeamPlayerContract::where('start_date', $start_date)
                                                                ->where('is_applied', 0)
                                                                ->where('team_id', $team->id)
                                                                ->orderBy('player_id')
                                                                ->orderBy('id', 'desc')
                                                                ->get();

                    $oldPlayer = '';
                    $oldStatus = '';
                    foreach ($ssContracts as $key => $contract) {
                        Log::info('cleaning contract for PlayerID : '.$contract->player_id.' | TeamID : '.$team->id);

                        if ($oldPlayer == $contract->player_id && $oldStatus == $contract->is_active) {
                            $contract->update(['is_applied' => true]);
                        }
                        $oldPlayer = $contract->player_id;
                        $oldStatus = $contract->is_active;
                    }
                }
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }

        Log::info('Supersub cleanup done');
        $this->info('Supersub cleanup done');
    }
}
