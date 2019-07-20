<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('party_id');
            $table->string('party_name');
            $table->string('party_type_id');
            $table->string('party_phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('zone');
            $table->string('owner_number');
            $table->string('contact_person');
            $table->string('credit_limit');
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
        Schema::dropIfExists('parties');
    }
}
