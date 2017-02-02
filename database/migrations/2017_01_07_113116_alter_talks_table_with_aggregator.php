<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTalksTableWithAggregator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talks', function ($table) {
            $table->integer('aggregator_id')->unsigned()->nullable()->after('series');
            $table->date('recordinguntil')->nullable()->after('recordingurl');
            $table->dropColumn('aggregator');
            $table->foreign('aggregator_id')->references('id')->on('aggregators');
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
            $table->dropColumn('aggregator_id');
            $table->dropColumn('recordinguntil');
        });
    }
}
