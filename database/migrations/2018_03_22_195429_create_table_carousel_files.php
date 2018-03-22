<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCarouselFiles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carouselfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->integer('file_id')->unsigned();
            $table->timestamps();
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carouselfiles');
    }
}

