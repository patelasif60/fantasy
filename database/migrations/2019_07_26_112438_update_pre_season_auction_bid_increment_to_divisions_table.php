<?php

use Illuminate\Database\Migrations\Migration;

class UpdatePreSeasonAuctionBidIncrementToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE `divisions` MODIFY `pre_season_auction_bid_increment` DECIMAL(8,2)  NULL;');
        \DB::statement('UPDATE `divisions` SET `pre_season_auction_bid_increment` = NULL WHERE `pre_season_auction_bid_increment` = 0;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('UPDATE `divisions` SET `pre_season_auction_bid_increment` = 0 WHERE `pre_season_auction_bid_increment` IS NULL;');
        \DB::statement('ALTER TABLE `divisions` MODIFY `pre_season_auction_bid_increment` DECIMAL(8,2) NOT NULL;');
    }
}
