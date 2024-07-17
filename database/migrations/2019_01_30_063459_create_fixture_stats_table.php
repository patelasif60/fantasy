<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fixture_id');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fixture_api_id');
            $table->unsignedInteger('player_id');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('player_api_id');
            $table->unsignedInteger('goal')->default(0);
            $table->unsignedInteger('own_goal')->default(0);
            $table->unsignedInteger('assist')->default(0);
            $table->unsignedInteger('goal_conceded')->default(0);
            $table->unsignedInteger('appearance')->default(0);
            $table->unsignedInteger('red_card')->default(0);
            $table->unsignedInteger('yellow_card')->default(0);
            $table->unsignedInteger('penalty_missed')->default(0);
            $table->unsignedInteger('penalty_save')->default(0);
            $table->unsignedInteger('goalkeeper_save')->default(0);
            $table->unsignedInteger('clean_sheet')->default(0);
            $table->unsignedInteger('club_win')->default(0);
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
        Schema::dropIfExists('fixture_stats');
    }
}
