<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('author');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->integer('priority', 2)->unsigned();
            $table->integer('resource_id')->unsigned();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tutorials');
    }
}
