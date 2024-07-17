<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fixture_id');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('event_type');
            $table->foreign('event_type')->references('id')->on('fixture_event_type')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('sub_player_id')->nullable();
            $table->foreign('sub_player_id')->references('id')->on('players')->onDelete('cascade')->onUpdate('cascade');
            $table->string('minute');
            $table->unsignedInteger('club_id');
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('api_event_id')->nullable();
            $table->dateTime('event_time')->nullable();
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
        Schema::dropIfExists('fixture_events');
    }
}
