<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutiontypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutiontypes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->boolean('deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('institutiontypes');
    }
}
