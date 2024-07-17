<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_counts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('consumer_id')->unsigned()->nullable();
            $table->foreign('consumer_id')->references('id')->on('consumers')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('count')->unsigned();
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
        Schema::dropIfExists('feed_counts');
    }
}
