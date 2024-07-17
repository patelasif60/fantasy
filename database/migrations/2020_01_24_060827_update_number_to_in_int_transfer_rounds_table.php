<?php

use Illuminate\Database\Migrations\Migration;

class UpdateNumberToInIntTransferRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE transfer_rounds MODIFY number integer;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE transfer_rounds MODIFY number varchar;');
    }
}
