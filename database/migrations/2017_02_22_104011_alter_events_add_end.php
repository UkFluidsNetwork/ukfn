<?php
use Illuminate\Database\Migrations\Migration;

class AlterEventsAddEnd extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->dateTime('end')->nullable()->after('start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function ($table) {
            $table->dropColumn('end');
        });
    }
}
