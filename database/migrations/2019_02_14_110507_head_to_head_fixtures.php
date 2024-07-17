<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HeadToHeadFixtures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('head_to_head_fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            // $table->integer('gameweek_id')->references('id')->on('gameweeks')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('league_phase_id')->references('id')->on('league_phases')->onDelete('cascade')->onUpdate('cascade');
            // $table->string('competition')->nullable();
            $table->integer('home_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('away_team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            // $table->string('api_id')->nullable();
            $table->enum('status', ['Fixture', 'Playing', 'Played', 'Awarded'])->default('Fixture');
            $table->enum('outcome', ['H', 'A', 'D'])->nullable();
            $table->integer('home_team_points')->nullable();
            $table->integer('away_team_points')->nullable();
            $table->unsignedInteger('home_team_head_to_head_points')->nullable();
            $table->unsignedInteger('away_team_head_to_head_points')->nullable();
            // $table->unsignedInteger('ht_home_score')->nullable();
            // $table->unsignedInteger('ht_away_score')->nullable();
            // $table->unsignedInteger('ft_home_score')->nullable();
            // $table->unsignedInteger('ft_away_score')->nullable();
            $table->integer('winner_id')->nullable()->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            // $table->string('stage')->nullable();
            // $table->datetime('date_time')->nullable();
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
        Schema::dropIfExists('head_to_head_fixtures');
    }
}
