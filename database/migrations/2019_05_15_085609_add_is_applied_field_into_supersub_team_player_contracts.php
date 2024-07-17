<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAppliedFieldIntoSupersubTeamPlayerContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supersub_team_player_contracts', function (Blueprint $table) {
            $table->boolean('is_applied')->default(false)->after('is_active');
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
            $table->dropColumn('is_applied');
        });
    }
}
