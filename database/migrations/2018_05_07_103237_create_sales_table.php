<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_id');
            $table->decimal('total_cost', 12, 2);
            $table->string('cust_email');
            $table->string('user_id');
            $table->string('handled_by');
            $table->string('order_placed'); // determine if ordered online or on-site
            $table->string('reference');
            $table->date('trans_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
