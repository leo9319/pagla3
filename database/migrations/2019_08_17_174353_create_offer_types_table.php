<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('offer_types')){
            Schema::create('offer_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('offer_name');
                $table->string('audit_approval')->default(-1);
                $table->string('management_approval')->default(-1);
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
        Schema::dropIfExists('offer_types');
    }
}
