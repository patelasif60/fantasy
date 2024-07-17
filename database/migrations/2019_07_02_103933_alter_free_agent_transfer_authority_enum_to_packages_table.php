<?php

use Illuminate\Database\Migrations\Migration;

class AlterFreeAgentTransferAuthorityEnumToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE packages CHANGE free_agent_transfer_authority free_agent_transfer_authority ENUM('chairman', 'chairmanandcochairman', 'all') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE packages CHANGE COLUMN free_agent_transfer_authority free_agent_transfer_authority ENUM('chairman', 'coChairman', 'all') NULL DEFAULT NULL");
    }
}
