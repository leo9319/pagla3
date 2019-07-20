<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustedBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjusted_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('amount');
            $table->string('reference');
            $table->string('reference_attatchment');
            $table->integer('management_approval', 1)->default(-1);
            $table->integer('sales_approval', 1)->default(-1);
            $table->integer('warehouse_approval', 1)->default(-1);
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
        Schema::dropIfExists('adjusted_balances');
    }
}
