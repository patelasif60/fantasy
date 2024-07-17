<?php

use App\Enums\AuctionRoundProcessEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\TiePreferenceEnum;
use App\Models\AuctionRound;
use App\Models\Division;
use Illuminate\Database\Seeder;

class AuctionRoundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = Division::where('auction_types', AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION)->get();

        foreach ($divisions as $division) {
            if (! $division->auctionRounds()->count()) {
                $start = now()->addHour(rand(100, 200))->subMinutes(rand(1, 55));
                $end = clone $start;

                $division->fill([
                    'auction_date' => $start,
                    'auction_closing_date' => null,
                    'tie_preference' => TiePreferenceEnum::EARLIEST_BID_WINS,
                ]);

                $division->save();

                AuctionRound::create([
                    'division_id' => $division->id,
                    'start' => $start,
                    'end' => $end->addHour(24),
                    'number' => 1,
                    'is_process' => AuctionRoundProcessEnum::UNPROCESSED,
                ]);
            }
        }
    }
}
