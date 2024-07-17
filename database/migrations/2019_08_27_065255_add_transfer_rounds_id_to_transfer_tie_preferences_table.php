<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferRoundsIdToTransferTiePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('transfer_tie_preferences', function (Blueprint $table) {
            $table->unsignedInteger('transfer_rounds_id')->after('number');
            $table->foreign('transfer_rounds_id')->references('id')->on('transfer_rounds')->onDelete('cascade');
        });

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_tie_preferences', function (Blueprint $table) {
            $table->dropColumn('transfer_rounds_id');
        });
    }
}
