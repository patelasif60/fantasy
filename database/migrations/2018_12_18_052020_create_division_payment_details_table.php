<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('consumers')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('division_id')->unsigned();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('token')->nullable();
            $table->string('worldpay_ordercode')->nullable();
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
        Schema::dropIfExists('division_payment_details');
    }
}
