<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildLinkedLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_linked_leagues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_linked_league_id');
            $table->foreign('parent_linked_league_id')->references('id')->on('parent_linked_leagues')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('division_id');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('child_linked_leagues');
    }
}
