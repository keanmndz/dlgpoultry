<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('activity');
            $table->string('user_email');
            $table->string('remarks');
            $table->string('user');
            $table->timestamp('changed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_changes');
    }
}
