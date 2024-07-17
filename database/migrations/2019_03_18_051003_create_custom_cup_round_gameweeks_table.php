<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomCupRoundGameweeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_cup_round_gameweeks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('custom_cup_round_id')->unsigned();
            $table->foreign('custom_cup_round_id')->references('id')->on('custom_cup_rounds')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('gameweek_id')->unsigned();
            $table->foreign('gameweek_id')->references('id')->on('gameweeks')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('custom_cup_round_gameweeks');
    }
}
