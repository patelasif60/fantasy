<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionEuropaFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champion_europa_fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('european_phase_id')->unsigned()->nullable();
            $table->enum('tournament_type', ['Champions League', 'Europa League'])->nullable()->default(null);
            $table->foreign('european_phase_id')->references('id')->on('european_phases')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('group_no')->unsigned()->nullable();
            $table->integer('home')->unsigned()->nullable();
            $table->integer('away')->unsigned()->nullable();
            $table->integer('home_points')->default('0');
            $table->integer('away_points')->default('0');
            $table->integer('winner')->unsigned()->nullable();
            $table->enum('bye_type', ['group', 'knockout'])->nullable()->default(null);
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
        Schema::dropIfExists('champion_europa_fixtures');
    }
}
