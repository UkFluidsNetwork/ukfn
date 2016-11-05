<?php
use Illuminate\Database\Migrations\Migration;

class AlterLogsUsers extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function ($table) {
            $table->integer('user_id')->unsigned()->nullable()->change();
        });
        Schema::table('users', function ($table) {
            $table->integer('title_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function ($table) {
            $table->integer('user_id')->unsigned()->change();
        });
        Schema::table('users', function ($table) {
            $table->integer('title_id')->unsigned()->change();
        });
    }
}
