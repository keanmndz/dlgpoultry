<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePulletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pullets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch');
            $table->string('batch_id');
            $table->integer('quantity');
            $table->date('date_added');
            $table->date('maturity');
            $table->string('remarks'); // if transferred already or not
            $table->string('added_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pullets');
    }
}
