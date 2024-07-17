<?php

namespace App\Console\Commands;

use App\Models\TeamPlayerContract;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class DuplicateContractRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duplicate:contract_remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all duplicate contracts of players with teams from "team_player_contracts" table - this targets only SUPERSUB contracts in transfer table';

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
        $endDate = Carbon::now()->format('Y-m-d H:i:s');

        $contracts = TeamPlayerContract::whereNull('end_date')
                            ->selectRaw('team_id, player_id, COUNT(player_id) AS open_contracts')
                            ->groupBy('team_id', 'player_id')
                            ->having('open_contracts', '>', 1)
                            // ->limit(9)
                            ->get();

        $this->info(count($contracts->toArray()).' affected contracts found');
        Log::info(count($contracts->toArray()).' affected contracts found');

        $this->info('Contracts cleanup START');
        Log::info('Contracts cleanup START');

        foreach ($contracts as $key => $contract) {

            // if($contract->team_id == 10989)

            $this->info('Contract cleanup for TeamID : '.$contract->team_id.' and PlayerID : '.$contract->player_id);
            Log::info('Contract cleanup for TeamID : '.$contract->team_id.' and PlayerID : '.$contract->player_id);

            $latestContract = TeamPlayerContract::where('team_id', $contract->team_id)
                                                    ->where('player_id', $contract->player_id)
                                                    ->orderBy('id', 'desc')
                                                    ->first();

            $dt1 = $latestContract->created_at->format('Y-m-d H:i:s');
            $dt2 = strtotime($dt1) + 1;
            $dt2 = Carbon::parse($dt2)->format('Y-m-d H:i:s');

            $transferCondition = [
                'team_id' => $contract->team_id,
                'transfer_type' => 'supersub',
            ];

            if ($latestContract->is_active == 1) {
                $transferCondition['player_in'] = $contract->player_id;
            } else {
                $transferCondition['player_out'] = $contract->player_id;
            }

            $transfers = Transfer::where($transferCondition)
                                        ->whereIn('transfer_date', [$dt1, $dt2])
                                        ->orderBy('id', 'desc')
                                        ->get();

            if (count($transfers->toArray()) > 1) {
                $index = 0;
                foreach ($transfers as $key => $transfer) {
                    // delete transfer records but leave the very first record i.e. the latest transfer record as we are getting records order by id descending
                    if ($index > 0) {
                        $response = $transfer->delete();
                    }
                    $index++;
                }

                // delete all player contracts with team but leave very latest contract record
                $response = TeamPlayerContract::where('team_id', $contract->team_id)
                                                    ->where('player_id', $contract->player_id)
                                                    ->where('id', '!=', $latestContract->id)
                                                    ->whereNull('end_date')
                                                    ->delete();
            // ->update(['end_date' => Carbon::now()->format('Y-m-d H:i:s')]);
            } elseif (isset($transfers[0]) && $transfers[0]->transfer_type == 'supersub') {
                // delete all player contracts with team but leave very latest contract record
                $response = TeamPlayerContract::where('team_id', $contract->team_id)
                                                        ->where('player_id', $contract->player_id)
                                                        ->where('id', '!=', $latestContract->id)
                                                        ->whereNull('end_date')
                                                        ->delete();
                // ->update(['end_date' => Carbon::now()->format('Y-m-d H:i:s')]);
            }
        }

        $this->info('Contracts cleanup END');
        Log::info('Contracts cleanup END');
    }
}
