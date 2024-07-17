<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('club_id')->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('player_id')->unsigned()->nullable();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('played')->default(0);
            $table->unsignedInteger('appearance')->default(0);
            $table->unsignedInteger('goal')->default(0);
            $table->unsignedInteger('assist')->default(0);
            $table->unsignedInteger('clean_sheet')->default(0);
            $table->unsignedInteger('goal_conceded')->default(0);
            $table->integer('total')->default('0');
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
        Schema::dropIfExists('history_stats');
    }
}
