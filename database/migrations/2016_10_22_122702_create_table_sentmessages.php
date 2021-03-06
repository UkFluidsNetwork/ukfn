<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSentmessages extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentmessages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from', 255);
            $table->string('to', 255);
            $table->string('subject', 255);
            $table->string('template', 255);
            $table->text('parameters')->nullable();
            $table->text('attachment')->nullable();
            $table->dateTime('sent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sentmessages');
    }
}
