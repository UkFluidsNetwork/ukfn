<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('competitionentry_id')->unsigned();
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('competitionentry_id')
                  ->references('id')
                  ->on('competitionentries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('votes');
    }
}
