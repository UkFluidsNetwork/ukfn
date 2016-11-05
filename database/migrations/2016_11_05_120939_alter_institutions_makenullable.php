<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInstitutionsMakenullable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutions', function ($table) {
            $table->integer('institutiontype_id')->unsigned()->nullable()->change();
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
            $table->integer('institutiontype_id')->unsigned()->change();
            $table->dateTime('moderated')->change();
        });
    }
}
