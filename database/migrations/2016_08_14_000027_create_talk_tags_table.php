<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalkTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned();
            $table->integer('talk_id')->unsigned();
            $table->timestamps();
            $table->boolean('deleted')->default(false);
            
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->foreign('talk_id')->references('id')->on('talks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('talk_tags');
    }
    
}
