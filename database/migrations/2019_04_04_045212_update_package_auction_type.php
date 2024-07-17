<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackageAuctionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('packages', 'auction_types')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->dropColumn('auction_types');
            });
        }
        Schema::table('packages', function (Blueprint $table) {
            $table->string('auction_types')->after('minimum_teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
