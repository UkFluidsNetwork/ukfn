<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sig_users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('main');
            $table->integer('sig_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->boolean('deleted');
            
            $table->foreign('sig_id')->references('id')->on('sigs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sig_users');
    }
    
}
