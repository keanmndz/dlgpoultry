<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalsTable extends Migration
{

    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('action');
            $table->string('module');
            $table->string('remarks');
            $table->string('status');
            $table->string('request_id')->nullable();
            $table->string('old_id')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('reorder_level')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->integer('price')->nullable();
            $table->integer('jumbo')->nullable();
            $table->integer('xlarge')->nullable();
            $table->integer('large')->nullable();
            $table->integer('medium')->nullable();
            $table->integer('small')->nullable();
            $table->integer('peewee')->nullable();
            $table->integer('softshell')->nullable();
            $table->integer('reject')->nullable();
            $table->string('lname')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('cust_email')->nullable();
            $table->string('password')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->integer('contact')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
