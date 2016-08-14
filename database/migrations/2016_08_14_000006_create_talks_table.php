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
            $table->string('url', 255);
            $table->string('title', 255);
            $table->string('speaker', 255);
            $table->string('speakerurl', 255);
            $table->string('venue', 255);
            $table->string('organiser', 255);
            $table->string('series', 255);
            $table->string('aggregator', 255);
            $table->timestamp('start');
            $table->timestamp('end');
            $table->longtext('abstract', 255);
            $table->longtext('message', 255);
            $table->timestamps();
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
        Schema::drop('talks');
    }
    
}
