<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVetsTable extends Migration
{
    public function up()
    {
        Schema::create('vets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('email');
            $table->string('fname');
            $table->string('lname');
            $table->text('diagnosis')->nullable();
            $table->text('prescription')->nullable();
            $table->text('notes')->nullable();
            $table->string('acknowledge');
            $table->date('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vets');
    }
}
