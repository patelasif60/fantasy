<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureLineupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture_lineups', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('lineup_type', ['Actual', 'Predicted']);
            $table->unsignedInteger('formation_id')->nullable();
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('formation_id')->references('id')->on('fixture_formations')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('fixture_id');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fixture_lineups');
    }
}
