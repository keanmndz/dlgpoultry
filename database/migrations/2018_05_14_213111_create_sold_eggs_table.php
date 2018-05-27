<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldEggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_eggs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_id');
            $table->string('size');
            $table->integer('quantity');
            $table->integer('batch_no');
            $table->string('batch_id');
            $table->date('trans_date');
            $table->string('trans_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold_eggs');
    }
}
