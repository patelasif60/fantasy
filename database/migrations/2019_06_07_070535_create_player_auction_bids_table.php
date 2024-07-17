<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerAuctionBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_auction_bids', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('division_id');
            $table->unsignedInteger('season_id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('player_id');
            $table->string('position', 5);
            $table->integer('round');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('high_bidder_id');
            $table->decimal('high_bid', 8, 2);
            $table->unsignedInteger('opening_bidder_id');
            $table->decimal('opening_bid', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_auction_bids');
    }
}
