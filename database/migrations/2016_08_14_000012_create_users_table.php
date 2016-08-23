<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('title_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('department_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('title_id')->references('id')->on('titles');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
