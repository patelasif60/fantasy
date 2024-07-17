<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBadgeColorFieldIntoPrizePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prize_packs', function (Blueprint $table) {
            $table->enum('badge_color', ['green', 'silver', 'gold'])->default('gold')->after('is_default');
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
            $table->dropColumn('badge_color');
        });
    }
}
