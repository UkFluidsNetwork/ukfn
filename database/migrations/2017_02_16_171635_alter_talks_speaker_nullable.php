<?php
use Illuminate\Database\Migrations\Migration;

class AlterTalksSpeakerNullable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function ($table) {
            $table->string('speaker', 255)->nullable()->change();
        });
    }
}
