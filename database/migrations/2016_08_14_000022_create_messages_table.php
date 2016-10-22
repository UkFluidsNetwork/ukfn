<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from', 255);
            $table->string('to', 255);
            $table->string('subject', 255);
            $table->longtext('body');
            $table->integer('user_id')->unsigned();
            $table->timestamp('sent');
            $table->timestamps();
            $table->boolean('public');
            $table->boolean('mailinglist');
            $table->boolean('deleted')->default(false);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
