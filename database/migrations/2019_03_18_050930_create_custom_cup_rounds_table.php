<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomCupRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_cup_rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('round');
            $table->integer('custom_cup_id')->unsigned();
            $table->foreign('custom_cup_id')->references('id')->on('custom_cups')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('custom_cup_rounds');
    }
}
