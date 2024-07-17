<?php

use Illuminate\Database\Migrations\Migration;

class AlterMoneyBackEnumPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE packages CHANGE money_back money_back ENUM('none', 'hunderedPercent', 'fiftyPercent', 'chairmaneditboughtsoldprice') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE packages CHANGE COLUMN money_back money_back ENUM('none', 'hunderedPercent', 'fiftyPercent') NULL DEFAULT NULL");
    }
}
