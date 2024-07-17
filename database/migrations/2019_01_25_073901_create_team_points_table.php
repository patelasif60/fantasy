<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->nullable();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('fixture_id')->unsigned()->nullable();
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('goal')->default('0');
            $table->integer('assist')->default('0');
            $table->integer('clean_sheet')->default('0');
            $table->integer('conceded')->default('0');
            $table->integer('appearance')->default('0');
            $table->integer('own_goal')->default('0');
            $table->integer('red_card')->default('0');
            $table->integer('yellow_card')->default('0');
            $table->integer('penalty_missed')->default('0');
            $table->integer('penalty_saved')->default('0');
            $table->integer('goalkeeper_save')->default('0');
            $table->integer('club_win')->default('0');
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
        Schema::dropIfExists('team_points');
    }
}
