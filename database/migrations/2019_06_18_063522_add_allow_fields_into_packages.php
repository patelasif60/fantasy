<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowFieldsIntoPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->enum('allow_defensive_midfielders', ['Yes', 'No'])->after('allow_process_bids')->nullable()->default(null);
            $table->enum('allow_merge_defenders', ['Yes', 'No'])->after('allow_defensive_midfielders')->nullable()->default(null);
            $table->enum('allow_weekend_changes_editable', ['Yes', 'No'])->after('allow_merge_defenders')->nullable()->default(null);
            $table->enum('allow_rollover_budget', ['Yes', 'No'])->after('allow_weekend_changes_editable')->nullable()->default(null);
            $table->enum('allow_available_formations', ['Yes', 'No'])->after('allow_rollover_budget')->nullable()->default(null);
            $table->enum('allow_supersubs', ['Yes', 'No'])->after('allow_available_formations')->nullable()->default(null);
            $table->enum('allow_seal_bid_deadline_repeat', ['Yes', 'No'])->after('allow_supersubs')->nullable()->default(null);
            $table->enum('allow_season_free_agent_transfer_limit', ['Yes', 'No'])->after('allow_seal_bid_deadline_repeat')->nullable()->default(null);
            $table->enum('allow_monthly_free_agent_transfer_limit', ['Yes', 'No'])->after('allow_season_free_agent_transfer_limit')->nullable()->default(null);
            $table->enum('allow_free_agent_transfer_authority', ['Yes', 'No'])->after('allow_monthly_free_agent_transfer_limit')->nullable()->default(null);
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
