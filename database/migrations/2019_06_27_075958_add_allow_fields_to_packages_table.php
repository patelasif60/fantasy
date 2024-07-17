<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowFieldsToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->enum('allow_enable_free_agent_transfer', ['Yes', 'No'])->after('allow_free_agent_transfer_authority')->nullable()->default(null);
            $table->enum('allow_free_agent_transfer_after', ['Yes', 'No'])->after('allow_enable_free_agent_transfer')->nullable()->default(null);
            $table->enum('allow_seal_bid_minimum', ['Yes', 'No'])->after('allow_free_agent_transfer_after')->nullable()->default(null);
            $table->enum('allow_money_back', ['Yes', 'No'])->after('allow_seal_bid_minimum')->nullable()->default(null);
            $table->enum('allow_tie_preference', ['Yes', 'No'])->after('allow_money_back')->nullable()->default(null);
            $table->json('money_back_types')->after('allow_tie_preference')->nullable()->default(null);
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
            $table->dropColumn('allow_enable_free_agent_transfer');
            $table->dropColumn('allow_free_agent_transfer_after');
            $table->dropColumn('allow_seal_bid_minimum');
            $table->dropColumn('allow_money_back');
            $table->dropColumn('allow_tie_preference');
            $table->dropColumn('money_back_types');
        });
    }
}
