<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSigInstitutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sig_institutions', function ($table) {
            $table->boolean('main')->nullable()->change();
            $table->dateTime('moderated')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function ($table) {
            $table->boolean('main')->change();
            $table->dateTime('moderated')->change();
        });
    }
}
