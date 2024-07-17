<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->references('id')->on('seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('competition')->nullable();
            $table->integer('home_club_id')->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('away_club_id')->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('api_id')->nullable();
            $table->enum('status', ['Fixture', 'Playing', 'Played', 'Cancelled', 'Postponed', 'Suspended', 'Awarded'])->default('Fixture');
            $table->enum('outcome', ['H', 'A', 'D'])->nullable();
            $table->unsignedInteger('home_score')->nullable();
            $table->unsignedInteger('away_score')->nullable();
            $table->unsignedInteger('ht_home_score')->nullable();
            $table->unsignedInteger('ht_away_score')->nullable();
            $table->unsignedInteger('ft_home_score')->nullable();
            $table->unsignedInteger('ft_away_score')->nullable();
            $table->integer('winner')->nullable()->references('id')->on('clubs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('stage')->nullable();
            $table->datetime('date_time')->nullable();
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
        Schema::dropIfExists('fixtures');
    }
}
