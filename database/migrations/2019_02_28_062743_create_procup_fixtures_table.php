<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcupFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procup_fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->unsigned()->nullable();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('procup_phase_id')->unsigned();
            $table->foreign('procup_phase_id')->references('id')->on('procup_phases')->onDelete('cascade');
            $table->integer('size')->unsigned();
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
        Schema::dropIfExists('procup_fixtures');
    }
}
