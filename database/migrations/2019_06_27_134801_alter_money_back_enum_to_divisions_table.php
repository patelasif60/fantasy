<?php

use Illuminate\Database\Migrations\Migration;

class AlterMoneyBackEnumToDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE divisions CHANGE money_back money_back ENUM('none', 'hunderedPercent', 'fiftyPercent', 'chairmaneditboughtsoldprice') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE divisions CHANGE COLUMN money_back money_back ENUM('none', 'hunderedPercent', 'fiftyPercent') NULL DEFAULT NULL");
    }
}
