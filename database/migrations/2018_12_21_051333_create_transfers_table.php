<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->unsignedInteger('player_in')->nullable()->default(null);
            $table->foreign('player_in')->references('id')->on('players');
            $table->unsignedInteger('player_out')->nullable()->default(null);
            $table->foreign('player_out')->references('id')->on('players');
            $table->enum('transfer_type', ['sealedbids', 'transfer', 'trade', 'auction', 'substitution', 'budgetcorrection', 'supersub', 'swapdeal'])->nullable()->default(null);
            $table->decimal('transfer_value', 8, 2)->nullable()->default(null);
            $table->dateTime('transfer_date')->nullable()->default(null);
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
        Schema::dropIfExists('transfers');
    }
}
