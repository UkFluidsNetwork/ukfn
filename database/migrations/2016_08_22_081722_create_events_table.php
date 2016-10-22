<?php

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('subtitle', 100)->nullable();
            $table->longtext('description')->nullable();
            $table->dateTime('start')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
        // populate
        DB::table('events')->insert(
            [
                [
                    'title' => 'UKFN launch event',
                    'subtitle' => 'ICL',
                    'description' => 'During the UK Fluids Conference',
                    'start' => '2016-09-09 13:30:00',
                    'user_id' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
