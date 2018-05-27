<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('type'); // if supply, equipment, product, feeds, medicine, etc.
            $table->integer('price'); // to know price of item even if not for sale
            $table->integer('quantity');
            $table->integer('unit'); // unit of measurement
            $table->integer('reorder_level');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
