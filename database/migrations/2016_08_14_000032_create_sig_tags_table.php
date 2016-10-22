<?php

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigTagsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sig_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('sig_id')->unsigned();
            $table->timestamps();
            $table->boolean('deleted')->default(false);

            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('sig_id')->references('id')->on('sigs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sig_tags');
    }
}
