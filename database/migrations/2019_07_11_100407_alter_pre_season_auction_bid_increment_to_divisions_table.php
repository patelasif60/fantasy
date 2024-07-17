<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPreSeasonAuctionBidIncrementToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('pre_season_auction_bid_increment');
        });
        Schema::table('divisions', function (Blueprint $table) {
            $table->decimal('pre_season_auction_bid_increment', 8, 2)->after('pre_season_auction_budget')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('pre_season_auction_bid_increment');
        });
        Schema::table('divisions', function (Blueprint $table) {
            $table->integer('pre_season_auction_bid_increment')->after('pre_season_auction_budget');
        });
    }
}
