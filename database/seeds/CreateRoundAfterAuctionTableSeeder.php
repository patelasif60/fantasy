<?php

use App\Enums\AuctionTypesEnum;
use App\Models\Division;
use App\Services\OnlineSealedBidTransferService;
use App\Services\TransferRoundService;
use Illuminate\Database\Seeder;

class CreateRoundAfterAuctionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = Division::where('auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)
                    ->whereNotNull('auction_closing_date')
                    ->get();

        $transferRoundService = app(TransferRoundService::class);
        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);

        foreach ($divisions as $division) {
            $tiePreference = $division->getOptionValue('tie_preference');

            if (! $division->transferRounds()->count()) {
                info("Create Round for $division->id ");
                //Create Transfer 1st Round when division auction close
                $transferRoundService->firstRoundStore($division);

                //Create transfer round tie preference
                $onlineSealedBidTransferService->transferRoundTiePreference($division, $tiePreference);
            }
        }
    }
}
