<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('payment_receiveds')){
            Schema::create('payment_receiveds', function (Blueprint $table) {
                $table->increments('id');
                $table->string('client_code');
                $table->date('date');
                $table->string('client_name');
                $table->string('collector');
                $table->string('paid_amount');
                $table->string('gc_percentage');
                $table->string('gc');
                $table->string('bd_reference');
                $table->string('bd_reference_attatchment');
                $table->string('money_receipt_ref');
                $table->string('total_received');
                $table->string('payment_mode');
                $table->string('cheque_clearing_date')->nullable();
                $table->string('cheque_clearing_status');
                $table->boolean('management_approval')->default(-1);
                $table->boolean('sales_approval')->default(-1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_receiveds');
    }
}
