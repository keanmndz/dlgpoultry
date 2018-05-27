<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChickensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chickens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch');
            $table->string('batch_id');
            $table->integer('quantity');
            $table->date('to_cull');
            $table->string('added_by');
            $table->string('remarks');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chickens');
    }
}
