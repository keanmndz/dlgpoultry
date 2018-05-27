<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id')->unique();
            $table->string('lname');
            $table->string('fname');
            $table->string('mname');
            $table->string('email');
            $table->string('password');
            $table->string('company');
            $table->string('address');
            $table->string('contact');
            $table->string('disabled_by');
            $table->string('status');
            $table->string('token');
            $table->string('remember_token');
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
        Schema::dropIfExists('customer_archives');
    }
}
