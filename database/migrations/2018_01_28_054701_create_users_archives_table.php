<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('password');
            $table->string('mobile');
            $table->string('address');
            $table->string('access');
            $table->string('token');
            $table->string('remember_token');
            $table->string('user_created');
            $table->string('disabled_by');
            $table->string('last_login');
            $table->string('status');
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
        Schema::dropIfExists('users_archives');
    }
}
