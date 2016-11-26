<?php
use Illuminate\Database\Migrations\Migration;

class AlterSuggestionsAddLeader extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suggestions', function ($table) {
            $table->boolean('leader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suggestions', function ($table) {
            $table->dropColumn('leader');
        });
    }
}
