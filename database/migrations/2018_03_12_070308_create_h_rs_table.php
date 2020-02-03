<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHRsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('h_rs')){
            Schema::create('h_rs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('employee_id');
                $table->string('name');
                $table->string('role');
                $table->string('zone');
                $table->string('phone');
                $table->boolean('audit_approval')->default(-1);
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
        Schema::dropIfExists('h_rs');
    }
}
