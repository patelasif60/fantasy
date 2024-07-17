<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureLineupPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_lineup_players', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lineup_id');
            $table->foreign('lineup_id')->references('id')->on('fixture_lineups')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('lineup_position', ['Goalkeeper (GK)', 'Full-back (FB)', 'Centre-back (CB)', 'Midfielder (MF)', 'Defensive Midfielder (DMF)', 'Striker (ST)', 'Substitute (SU)']);
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
        Schema::dropIfExists('fixture_lineup_players');
    }
}
