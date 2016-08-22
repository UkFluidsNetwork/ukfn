<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institutiontype_id')->unsigned();
            $table->integer('address_id')->unsigned();
            $table->timestamps();
            $table->string('name', 255);
            $table->dateTime('moderated');
            $table->boolean('deleted')->default(false);
            
            $table->foreign('institutiontype_id')->references('id')->on('institutiontypes');
            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('institutions');
    }
}
