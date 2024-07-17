<?php

namespace App\Console\Commands;

use App\Enums\YesNoEnum;
use App\Services\AuctionRoundService;
use App\Services\OnlineSealedBidService;
use Illuminate\Console\Command;

class ProcessOnlineSealBidRoundAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:process-round';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command automatic process seal bid round';

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
        $service = app(OnlineSealedBidService::class);
        $auctionRoundService = app(AuctionRoundService::class);
        $divisions = $service->getActiveBidDivision();

        foreach ($divisions as $division) {
            if (! $division->manual_bid) {
                if ($division->package->manual_bid != YesNoEnum::NO) {
                    continue;
                }
            }

            $endRound = $auctionRoundService->getEndRound($division);
            if ($endRound) {
                $onlineSealedBids = $service->getAutomaticBidRoundData($division);
                if ($onlineSealedBids->count()) {
                    $service->startOnlineSealedBidProcess($onlineSealedBids, $division, $endRound);
                }
            }
        }

        $this->info('Online seal bid round process end on '.now().'');
    }
}
