<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `users` ADD COLUMN `signin_token` VARCHAR(255) NULL AFTER `push_registration_id`, ADD COLUMN `auto_signin` BOOLEAN NULL AFTER `signin_token`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE `users` ADD COLUMN `signin_token` VARCHAR(255) NULL AFTER `push_registration_id`, ADD COLUMN `auto_signin` BOOLEAN NULL AFTER `signin_token`");
    }
}
