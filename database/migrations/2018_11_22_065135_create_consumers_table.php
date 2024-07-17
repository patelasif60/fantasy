<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('dob')->nullable();
            $table->string('address_1')->nullable()->default(null);
            $table->string('address_2')->nullable()->default(null);
            $table->string('town')->nullable()->default(null);
            $table->string('county')->nullable()->default(null);
            $table->string('post_code')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('telephone')->nullable()->default(null);
            $table->string('country_code')->nullable()->default(null);
            $table->string('favourite_club')->nullable()->default(null);
            $table->text('introduction')->nullable()->default(null);
            $table->boolean('has_games_news');
            $table->boolean('has_fl_marketing')->default(0);
            $table->boolean('has_third_parities');
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
        Schema::dropIfExists('consumers');
    }
}
