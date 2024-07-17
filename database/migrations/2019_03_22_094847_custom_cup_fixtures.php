<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CustomCupFixtures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_cup_fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('custom_cup_round_id')->unsigned();
            $table->foreign('custom_cup_round_id')->references('id')->on('custom_cup_rounds')->onDelete('cascade');
            $table->integer('gameweek_id')->unsigned();
            $table->foreign('gameweek_id')->references('id')->on('gameweeks')->onDelete('cascade');
            $table->integer('home')->unsigned();
            $table->integer('away')->nullable()->default(null);
            $table->integer('home_points')->nullable()->default(null);
            $table->integer('away_points')->nullable()->default(null);
            $table->integer('winner')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('custom_cup_fixtures');
    }
}
