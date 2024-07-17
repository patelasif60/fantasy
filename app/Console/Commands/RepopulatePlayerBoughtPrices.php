<?php

namespace App\Console\Commands;

use App\Enums\TransferTypeEnum;
use App\Models\Transfer;
use Illuminate\Console\Command;

class RepopulatePlayerBoughtPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repopulate:player-bought-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to repopulate player bought prices';

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
        $transfers = Transfer::where(function ($query) {
            $query->where('transfer_type', TransferTypeEnum::SUBSTITUTION)
                                    ->orWhere('transfer_type', TransferTypeEnum::SUPERSUB);
        })->where(function ($query) {
            $query->where('transfer_value', 0)
                                    ->orWhereNull('transfer_value');
        })->whereNotNull('player_in')->get();
        $this->info('Total:'.$transfers->count());
        foreach ($transfers as $value) {
            $this->info('Team Id is '.$value->team_id);
            $this->info('Player Id is '.$value->player_in);
            if (! empty($value->player_in)) {
                $player = Transfer::where('team_id', $value->team_id)->where('player_in', $value->player_in)->where(function ($query) {
                    $query->where('transfer_type', TransferTypeEnum::TRANSFER)
                                        ->orWhere('transfer_type', TransferTypeEnum::AUCTION);
                })->orderBy('transfer_date', 'desc')->first();
                if ($player) {
                    $value->update(['transfer_value' => $player->transfer_value]);
                    $this->info('Bought price updated for:'.$value);
                }
            }
        }
        $this->info('Total:'.$transfers->count());
        $this->info('Repopulate Player Bought Prices - End process '.now().'');
    }
}
