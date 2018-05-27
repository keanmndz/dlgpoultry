<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->decimal('total_cost', 12, 2);
            $table->string('cust_email');
            $table->string('user_id');
            $table->string('handled_by');
            $table->string('order_placed'); // determine if ordered online or on-site
            $table->string('status');
            $table->timestamp('trans_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
