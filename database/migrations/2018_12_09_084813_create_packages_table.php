<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('is_enabled', ['Yes', 'No'])->nullable();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->enum('available_new_user', ['Yes', 'No'])->nullable();
            $table->decimal('price', 8, 2);
            $table->enum('private_league', ['Yes', 'No'])->nullable();
            $table->integer('minimum_teams')->nullable();

            $table->enum('auction_types', ['Live', 'Online'])->nullable();
            $table->integer('pre_season_auction_budget');
            $table->integer('pre_season_auction_bid_increment');
            $table->enum('budget_rollover', ['Yes', 'No'])->nullable();
            $table->integer('seal_bids_budget');
            $table->decimal('seal_bid_increment', 8, 2);
            $table->integer('seal_bid_minimum');
            $table->enum('manual_bid', ['Yes', 'No'])->nullable();
            $table->dateTime('first_seal_bid_deadline')->nullable()->default(null);
            $table->enum('seal_bid_deadline_repeat', ['dontRepeat', 'everyMonth', 'everyFortnight', 'everyWeek'])->nullable();
            $table->integer('max_seal_bids_per_team_per_round');
            $table->enum('money_back', ['none', 'hunderedPercent', 'fiftyPercent'])->nullable();
            $table->enum('tie_preference', ['no', 'earliestBidWins', 'lowerLeaguePositionWins', 'higherLeaguePositionWins', 'randomlyAllocated', 'randomlyAllocatedReverses'])->nullable();
            $table->enum('custom_squad_size', ['Yes', 'No'])->nullable();
            $table->integer('default_squad_size');
            $table->enum('custom_club_quota', ['Yes', 'No'])->nullable();
            $table->integer('default_max_player_each_club');
            $table->json('available_formations')->nullable()->default(null);
            $table->enum('defensive_midfields', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('merge_defenders', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('enable_free_agent_transfer', ['Yes', 'No'])->nullable();
            $table->enum('free_agent_transfer_authority', ['chairman', 'coChairman', 'all'])->nullable()->default(null);
            $table->enum('free_agent_transfer_after', ['auctionEnd', 'seasonStart'])->nullable()->default(null);
            $table->integer('season_free_agent_transfer_limit');
            $table->integer('monthly_free_agent_transfer_limit');
            $table->enum('enabled_weekend_changes', ['Yes', 'No'])->nullable();
            $table->enum('allow_weekend_changes', ['Yes', 'No'])->nullable();
            $table->enum('allow_custom_cup', ['Yes', 'No'])->nullable();
            $table->enum('allow_fa_cup', ['Yes', 'No'])->nullable();
            $table->enum('allow_champion_league', ['Yes', 'No'])->nullable();
            $table->enum('allow_europa_league', ['Yes', 'No'])->nullable();
            $table->enum('allow_head_to_head', ['Yes', 'No'])->nullable();
            $table->enum('allow_linked_league', ['Yes', 'No'])->nullable();
            $table->enum('digital_prize_type', ['Standard', 'Basic'])->nullable();
            $table->enum('allow_custom_scoring', ['Yes', 'No'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
