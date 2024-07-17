<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->enum('events', ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_x5'])->nullable()->default(null);

            $table->integer('goal_keeper')->nullable()->default(null);
            $table->integer('centre_back')->nullable()->default(null);
            $table->integer('full_back')->nullable()->default(null);
            $table->integer('defensive_mid_fielder')->nullable()->default(null);
            $table->integer('mid_fielder')->nullable()->default(null);
            $table->integer('striker')->nullable()->default(null);
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
        Schema::dropIfExists('division_points');
    }
}
