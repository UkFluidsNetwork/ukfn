<?php
use Illuminate\Database\Migrations\Migration;

class AlterTalksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function ($table) {
            $table->string('teradekip', 15)->nullable()->after('message');
            $table->text('streamingurl')->nullable()->after('teradekip');
            $table->text('recordingurl')->nullable()->after('streamingurl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talks', function ($table) {
            $table->dropColumn('teradekip');
            $table->dropColumn('streamingurl');
            $table->dropColumn('recordingurl');
        });
    }
}
