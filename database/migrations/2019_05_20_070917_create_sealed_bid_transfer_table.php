<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSealedBidTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sealed_bid_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transfer_rounds_id');
            $table->foreign('transfer_rounds_id')->references('id')->on('transfer_rounds')->onDelete('cascade');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('player_in');
            $table->foreign('player_in')->references('id')->on('players')->onDelete('cascade');
            $table->unsignedInteger('player_out');
            $table->foreign('player_out')->references('id')->on('players')->onDelete('cascade');
            $table->decimal('amount', 8, 2)->nullable()->default(null);
            $table->enum('status', ['W', 'L'])->nullable();
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
        Schema::dropIfExists('sealed_bid_transfers');
    }
}
