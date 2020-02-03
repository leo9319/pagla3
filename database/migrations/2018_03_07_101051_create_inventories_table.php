<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('inventories')){
            Schema::create('inventories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('product_id');
                $table->string('brand');
                $table->string('quantity');
                $table->date('expiry_date');
                $table->string('wholesale_rate');
                $table->string('mrp');
                $table->string('product_name');
                $table->string('product_type');
                $table->string('cost')->nullable();
                $table->string('batch_code');
                $table->string('offer_rate')->nullable();
                $table->date('offer_start')->nullable();
                $table->date('offer_end')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
