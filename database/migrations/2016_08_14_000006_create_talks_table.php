<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('talkid')->unsigned(); // FIXME: not sure if this should be an string
            $table->string('title', 255);
            $table->string('speaker', 255);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('url', 255)->nullable();
            $table->string('speakerurl', 255)->nullable();
            $table->string('venue', 255)->nullable();
            $table->string('organiser', 255)->nullable();
            $table->string('series', 255)->nullable();
            $table->string('aggregator', 255)->nullable();
            $table->longtext('abstract', 255)->nullable();
            $table->longtext('message', 255)->nullable();
            $table->timestamps();
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('talks');
    }
    
}
