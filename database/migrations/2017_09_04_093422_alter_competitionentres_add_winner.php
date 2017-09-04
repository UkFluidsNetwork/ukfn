<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompetitionentresAddWinner extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competitionentries', function ($table) {
            $table->string('contestant')->nullable()->after('description');
            $table->string('department')->nullable()->after('contestant');
            $table->boolean('winner')->default(false)->after('department');
            $table->integer('institution_id')->unsigned()
                   ->nullable()
                   ->after('department');

            $table->foreign('institution_id')
                  ->references('id')
                  ->on('institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competitionentries', function ($table) {
            $table->dropColumn('contestant');
            $table->dropColumn('department');
            $table->dropColumn('institution_id');
            $table->dropColumn('winner');
        });
    }
}

