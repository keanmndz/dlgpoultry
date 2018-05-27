<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectEggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_eggs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch_id');
            $table->integer('quantity');
            $table->integer('total');
            $table->string('remarks');
            $table->string('added_by');
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
        Schema::dropIfExists('reject_eggs');
    }
}
