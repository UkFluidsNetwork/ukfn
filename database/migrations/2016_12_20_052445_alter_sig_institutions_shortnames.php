<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSigInstitutionsShortnames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigs', function ($table) {
            $table->text('shortname')->nullable()->after('name');
        });
        
        Schema::table('institutions', function ($table) {
            $table->text('shortname')->nullable()->after('name');
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
            $table->dropColumn('shortname');
        });
    
        Schema::table('institutions', function ($table) {
            $table->dropColumn('shortname');
        });
    }
}
