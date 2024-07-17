<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSealBidMinimumToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('seal_bid_minimum');
        });
        Schema::table('divisions', function (Blueprint $table) {
            $table->decimal('seal_bid_minimum', 8, 2)->after('seal_bid_increment')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('seal_bid_minimum');
        });
        Schema::table('divisions', function (Blueprint $table) {
            $table->integer('seal_bid_minimum')->after('seal_bid_increment');
        });
    }
}
