<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sales_returns')){
            Schema::create('sales_returns', function (Blueprint $table) {
                $table->increments('id');
                $table->date('date');
                $table->string('invoice_no');
                $table->string('client_id');
                $table->decimal('total_sales_return', 10, 2);
                $table->decimal('discount_percentage', 4, 2);
                $table->decimal('amount_after_discount', 10, 2)->nullable();
                $table->integer('present_sr_id')->nullable();
                $table->text('remarks')->nullable();
                $table->boolean('audit_approval')->default(-1);
                $table->boolean('management_approval')->default(-1);
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
        Schema::dropIfExists('sales_returns');
    }
}
