<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id');
                $table->date('date');
                $table->string('product_code');
                $table->string('product_name');     
                $table->string('brand');
                $table->string('product_size');
                $table->string('case_size');
                $table->string('product_type');
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
        Schema::dropIfExists('products');
    }
}
