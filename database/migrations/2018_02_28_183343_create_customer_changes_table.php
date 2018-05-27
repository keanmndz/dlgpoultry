<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity');
            $table->string('cust_email');
            $table->string('remarks');
            $table->string('user');
            $table->timestamp('changed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_changes');
    }
}
