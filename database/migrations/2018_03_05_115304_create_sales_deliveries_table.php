<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sales_deliveries')){
            Schema::create('sales_deliveries', function (Blueprint $table) {
                $table->increments('id');
                $table->string('shop_id');
                $table->string('salesman');
                $table->date('salesman_start');
                $table->date('salesman_end')->nullable();
                $table->boolean('discontinued')->nullable();
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
        Schema::dropIfExists('sales_deliveries');
    }
}
