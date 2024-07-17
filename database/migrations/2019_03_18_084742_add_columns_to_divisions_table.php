<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->integer('champions_league_team')->unsigned()->nullable()->after('monthly_free_agent_transfer_limit');
            $table->integer('europa_league_team_1')->unsigned()->nullable()->after('champions_league_team');
            $table->integer('europa_league_team_2')->unsigned()->nullable()->after('europa_league_team_1');
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
            //
        });
    }
}
