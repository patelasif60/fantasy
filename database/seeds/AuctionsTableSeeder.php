<?php

use App\Models\Auction;
use Illuminate\Database\Seeder;

class AuctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auctions = ['Sealed Bids Auction', 'Real Time Auction', 'Manual Entry'];
        foreach ($auctions as $auction) {
            $auction = ucwords($auction);
            $auctionTag = lcfirst(str_replace(' ', '', $auction));
            factory(Auction::class)->create(['name' => $auction, 'tag' => $auctionTag]);
        }
    }
}
