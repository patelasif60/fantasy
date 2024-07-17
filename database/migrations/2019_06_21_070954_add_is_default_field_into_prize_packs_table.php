<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDefaultFieldIntoPrizePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prize_packs', function (Blueprint $table) {
            $table->boolean('is_default')->default(0)->after('is_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prize_packs', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
}