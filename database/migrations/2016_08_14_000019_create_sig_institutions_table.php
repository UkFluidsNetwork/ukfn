<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sig_institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('main');
            $table->integer('sig_id')->unsigned();
            $table->integer('institution_id')->unsigned();
            $table->timestamps();
            $table->dateTime('moderated');
            $table->boolean('deleted')->default(false);
            
            $table->foreign('sig_id')->references('id')->on('sigs');
            $table->foreign('institution_id')->references('id')->on('institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sig_institutions');
    }
}
