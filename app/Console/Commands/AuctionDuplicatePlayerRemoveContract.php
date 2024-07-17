<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuctionDuplicatePlayerRemoveContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:remove-duplicate-players-contracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate players contracts';

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
            $team = \App\Models\Team::find($result->team_id);
            $contracts = \App\Models\TeamPlayerContract::where('team_id', $team->id)->whereNull('end_date')->orderBy('player_id')->get();
            $amount = 0;
            foreach ($contracts->groupBy('player_id') as $contract) {
                if ($contract->count() > 1) {
                    $contractSlice = $contract->slice(1, $contract->count());

                    $transfers = \App\Models\Transfer::where('team_id', $team->id)
                    ->where('player_in', $contractSlice->first()->player_id)
                    ->where('transfer_type', 'auction')
                    ->orderBy('player_in')
                    ->get();

                    if ($transfers->count() > 1) {
                        $transferSlice = $transfers->slice(1, $transfers->count());
                        //Delete transfer
                        foreach ($transferSlice as $tr) {
                            $tr->delete();
                        }
                    }

                    //Delete Contract
                    foreach ($contractSlice as $cr) {
                        $cr->delete();
                    }
                }
            }

            $amount = \App\Models\Transfer::where('team_id', $team->id)->sum('transfer_value');
            $team->team_budget = $amount;
            $team->save();
            $this->info('Team budget updated for '.$team->id.' '.$amount.'');
        }

        $this->info('End process '.now().'');
    }
}
