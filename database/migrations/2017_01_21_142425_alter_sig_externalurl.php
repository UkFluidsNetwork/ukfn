<?php

use Illuminate\Database\Migrations\Migration;

class AlterSigExternalurl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigs', function ($table) {
            $table->text('url')->nullable()->after('twitterurl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sigs', function ($table) {
            $table->dropColumn('url');
        });
    }
}
