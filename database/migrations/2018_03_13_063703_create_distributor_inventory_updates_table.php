<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributorInventoryUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_inventory_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_code');
            $table->string('product_code');
            $table->string('product_type');
            $table->integer('ppu');
            $table->string('client_name');
            $table->string('product_name');
            $table->string('brand');
            $table->integer('quantity');
            $table->integer('commission_percentage');
            $table->decimal('ppu_after_commission', 11, 2);
            $table->decimal('total_commission', 11, 2);
            $table->decimal('total_before_commission', 11, 2);
            $table->decimal('CIVAC', 11, 2);
            $table->string('remarks')->nullable();
            $table->boolean('audit_approval')->default(-1);
            $table->boolean('management_approval')->default(-1);
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
        Schema::dropIfExists('distributor_inventory_updates');
    }
}
