<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile');
            $table->string('address');
            $table->string('access');
            $table->string('token', 10);
            $table->string('remember_token');
            $table->timestamps();
            $table->string('last_login');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
