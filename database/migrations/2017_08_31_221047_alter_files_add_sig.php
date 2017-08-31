<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFilesAddSig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                Schema::table('files', function ($table) {
            $table->integer('sig_id')
                   ->unsigned()->nullable()->after('tutorial_id');
            $table->foreign('sig_id')->references('id')->on('sigs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('files', function ($table) {
            $table->dropColumn('tutorial_id');
        });
    }
}
