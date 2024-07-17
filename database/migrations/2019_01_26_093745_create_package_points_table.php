<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->enum('events', ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_x5'])->nullable()->default(null);

            $table->integer('goal_keeper');
            $table->integer('centre_back');
            $table->integer('full_back');
            $table->integer('defensive_mid_fielder');
            $table->integer('mid_fielder');
            $table->integer('striker');

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
        Schema::dropIfExists('package_points');
    }
}
