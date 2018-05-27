<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eggs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch_id');
            $table->integer('jumbo');
            $table->integer('xlarge');
            $table->integer('large');
            $table->integer('medium');
            $table->integer('small');
            $table->integer('peewee');
            $table->integer('softshell');
            $table->integer('total_jumbo');
            $table->integer('total_xlarge');
            $table->integer('total_large');
            $table->integer('total_medium');
            $table->integer('total_small');
            $table->integer('total_peewee');
            $table->integer('total_softshell');
            $table->date('lifetime');
            $table->string('added_by');
            $table->date('created_at');
            $table->string('time_added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eggs');
    }
}
