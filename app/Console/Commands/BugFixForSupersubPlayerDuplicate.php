<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BugFixForSupersubPlayerDuplicate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supersub:player-duplicate-remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate player from team_player_contract and transfers';

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
        $this->info('Start process '.now().'');

        $results = \DB::select(\DB::raw('SELECT t.team_id FROM (SELECT team_id, player_id, COUNT(*) AS c FROM team_player_contracts WHERE end_date IS NULL GROUP BY team_id, player_id HAVING c > 1) AS t GROUP BY t.team_id'));

        foreach ($results as $result) {
            $contracts = \App\Models\TeamPlayerContract::where('team_id', $result->team_id)
            ->whereNull('end_date')
            ->orderBy('player_id')
            ->get();

            foreach ($contracts->groupBy('player_id') as $contract) {
                if ($contract->count() > 1) {
                    $contractSlice = $contract->slice(1, $contract->count());

                    $this->info('Affected team is - '.$contractSlice->first()->team_id);

                    $transfers = \DB::select(\DB::raw('DELETE tf1 FROM transfers AS tf1, transfers AS tf2 
                    WHERE tf1.id > tf2.id
                    AND tf1.team_id = tf2.team_id 
                    AND tf1.player_in = tf2.player_in 
                    AND tf1.player_out = tf2.player_out
                    AND tf1.transfer_type = tf2.transfer_type
                    AND tf1.transfer_date = tf2.transfer_date
                    AND tf1.team_id = '.$contractSlice->first()->team_id.'
                    AND tf1.player_in = '.$contractSlice->first()->player_id."
                    AND tf1.transfer_type = 'supersub'"));

                    //Delete Contract
                    foreach ($contractSlice as $cr) {
                        $cr->delete();
                    }
                }
            }
        }

        $this->info('End process '.now().'');
    }
}
