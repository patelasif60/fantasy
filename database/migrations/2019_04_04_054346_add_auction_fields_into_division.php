<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuctionFieldsIntoDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('divisions', 'auction_types')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->dropColumn('auction_types');
            });
        }
        Schema::table('divisions', function (Blueprint $table) {
            $table->enum('auction_types', ['Online sealed bids', 'Live online', 'Live offline'])->after('parent_division_id');
            $table->text('auction_venue')->nullable();
            $table->unsignedInteger('auctioneer_id')->nullable();
            $table->foreign('auctioneer_id')->references('id')->on('consumers')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('auction_closing_date')->nullable()->default(null);
            $table->enum('allow_passing_on_nominations', ['Yes', 'No'])->nullable()->default(null)->after('auction_types');
            $table->integer('remote_nomination_time_limit')->nullable()->default(null)->after('allow_passing_on_nominations');
            $table->integer('remote_bidding_time_limit')->nullable()->default(null)->after('remote_nomination_time_limit');
            $table->enum('allow_managers_to_enter_own_bids', ['Yes', 'No'])->nullable()->default(null)->after('remote_bidding_time_limit');
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
