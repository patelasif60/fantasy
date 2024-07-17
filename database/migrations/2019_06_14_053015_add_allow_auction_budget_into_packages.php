<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowAuctionBudgetIntoPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->enum('allow_auction_budget', ['Yes', 'No'])->after('enable_supersubs')->nullable()->default(null);
            $table->enum('allow_bid_increment', ['Yes', 'No'])->after('allow_auction_budget')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
        });
    }
}
