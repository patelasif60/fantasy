<?php

namespace App\Console\Commands;

use App\Services\OnlineSealedBidTransferService;
use App\Services\TransferRoundService;
use Illuminate\Console\Command;

class ProcessOnlineSealBidTransfersRoundAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:process-transfers-round';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command automatic process seal bid trasnfers round';

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
        $this->info('Online seal bid round process start on '.now().'');
        $service = app(OnlineSealedBidTransferService::class);
        $transferRoundService = app(TransferRoundService::class);
        $divisions = $service->getActiveBidDivision();

        foreach ($divisions as $division) {
            $endRound = $transferRoundService->getEndRound($division);
            if ($endRound) {
                $onlineSealedBids = $service->getBidRoundData($endRound);
                if ($onlineSealedBids->count()) {
                    $service->startOnlineSealedBidProcess($onlineSealedBids, $division, $endRound);
                }
            }
        }

        $this->info('Online seal bid round process end on '.now().'');
    }
}
