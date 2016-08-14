<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution_users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('main');
            $table->integer('institution_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->boolean('deleted');
            
            $table->foreign('institution_id')->references('id')->on('institutions');
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
        Schema::drop('institution_users');
    }
    
}
