<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInSupersubTeamPlayerContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supersub_team_player_contracts', function (Blueprint $table) {
            $table->datetime('applied_at')->after('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supersub_team_player_contracts', function (Blueprint $table) {
            $table->dropColumn('applied_at');
        });
    }
}
