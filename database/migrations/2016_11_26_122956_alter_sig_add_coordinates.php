<?php
use Illuminate\Database\Migrations\Migration;

class AlterSigAddCoordinates extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigs', function ($table) {
            $table->text('description')->nullable()->after('name');
        });
        
        Schema::table('institutions', function ($table) {
            $table->string('lat')->nullable()->after('name');
            $table->string('lng')->nullable()->after('name');
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
            $table->dropColumn('description');
        });
        
        Schema::table('institutions', function ($table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
}
