<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address1', 255);
            $table->string('address2', 255);
            $table->string('address3', 255);
            $table->string('city', 255);
            $table->string('postcode', 255);
            $table->integer('county_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->timestamps();
            $table->boolean('deleted');
            
            $table->foreign('county_id')->references('id')->on('counties');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');
    }
    
}
