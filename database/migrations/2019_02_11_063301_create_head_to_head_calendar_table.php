<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadToHeadCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('head_to_head_calendar', function (Blueprint $table) {
            $table->integer('size')->unsigned();
            $table->string('number')->nullable();
            $table->integer('home_team_number')->unsigned();
            $table->integer('away_team_number')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('head_to_head_calendar');
    }
}
