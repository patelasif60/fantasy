<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaguePhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gameweek_id')->unsigned()->nullable();
            $table->foreign('gameweek_id')->references('id')->on('gameweeks')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('size')->unsigned();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('league_phases');
    }
}
