<?php

namespace App\Console\Commands;

use App\Jobs\OnlineSealedBidsAuctionCompletedEmail;
use App\Models\Division;
use App\Services\AuctionService;
use App\Services\OnlineSealedBidTransferService;
use App\Services\TransferRoundService;
use Illuminate\Console\Command;

class AuctionCloseOnlineSealBidManually extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:manually-close-id-specific';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Id specific auction close';

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
        $auctionService = app(AuctionService::class);

        $division = Division::find(422);

        if ($auctionService->allTeamSizeFull($division)) {
            $auctionService->close($division);
            OnlineSealedBidsAuctionCompletedEmail::dispatch($division);
            //Create Transfer 1st Round when division auction close
            $transferRoundService = app(TransferRoundService::class);
            $transferRoundService->firstRoundStore($division);

            $tiePreference = $division->getOptionValue('tie_preference');
            //Create transfer round tie preference
            $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
            $onlineSealedBidTransferService->transferRoundTiePreference($division, $tiePreference);

            $this->info('Auction Closed');
        } else {
            $this->info('Not Close');
        }
    }
}
