<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsManuallyProcessToSealedBidTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sealed_bid_transfers', function (Blueprint $table) {
            $table->enum('manually_process_status', ['pending', 'processed', 'completed'])->default('pending')->after('status');
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
            $table->dropColumn('manually_process_status');
        });
    }
}
