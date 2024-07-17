<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uuid')->nullable();
            $table->unsignedInteger('chairman_id');
            $table->foreign('chairman_id')->references('id')->on('consumers');
            $table->unsignedInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
            $table->text('introduction')->nullable();
            $table->integer('parent_division_id')->nullable()->default(0);

            $table->enum('auction_types', ['Live', 'Online'])->nullable()->default(null);
            $table->dateTime('auction_date')->nullable()->default(null);
            $table->integer('pre_season_auction_budget')->nullable()->default(null);
            $table->integer('pre_season_auction_bid_increment')->nullable()->default(null);
            $table->enum('budget_rollover', ['Yes', 'No'])->nullable()->default(null);
            $table->integer('seal_bids_budget')->nullable()->default(null);
            $table->decimal('seal_bid_increment', 8, 2)->nullable()->default(null);
            $table->integer('seal_bid_minimum')->nullable()->default(null);
            $table->enum('manual_bid', ['Yes', 'No'])->nullable()->default(null);
            $table->dateTime('first_seal_bid_deadline')->nullable()->default(null);
            $table->enum('seal_bid_deadline_repeat', ['dontRepeat', 'everyMonth', 'everyFortnight', 'everyWeek'])->nullable()->default(null);
            $table->integer('max_seal_bids_per_team_per_round')->nullable();
            $table->enum('money_back', ['none', 'hunderedPercent', 'fiftyPercent'])->nullable();
            $table->enum('tie_preference', ['no', 'earliestBidWins', 'lowerLeaguePositionWins', 'higherLeaguePositionWins', 'randomlyAllocated', 'randomlyAllocatedReverses'])->nullable();
            $table->text('rules')->nullable()->default(null);
            $table->integer('default_squad_size')->nullable()->default(null);
            $table->integer('default_max_player_each_club')->nullable()->default(null);
            $table->json('available_formations')->nullable()->default(null);
            $table->enum('defensive_midfields', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('merge_defenders', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('allow_weekend_changes', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('enable_free_agent_transfer', ['Yes', 'No'])->nullable()->default(null);
            $table->enum('free_agent_transfer_authority', ['chairman', 'coChairman', 'all'])->nullable()->default(null);
            $table->enum('free_agent_transfer_after', ['auctionEnd', 'seasonStart'])->nullable();
            $table->integer('season_free_agent_transfer_limit')->nullable()->default(null);
            $table->integer('monthly_free_agent_transfer_limit')->nullable()->default(null);
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
        Schema::dropIfExists('divisions');
    }
}
