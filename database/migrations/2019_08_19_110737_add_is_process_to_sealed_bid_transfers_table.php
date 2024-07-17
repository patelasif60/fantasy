<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProcessToSealedBidTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sealed_bid_transfers', function (Blueprint $table) {
            $table->boolean('is_process')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sealed_bid_transfers', function (Blueprint $table) {
            $table->dropColumn('is_process');
        });
    }
}
