<?php
use Illuminate\Database\Migrations\Migration;

class AlterTagsMakeModeratedNullable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function ($table) {
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
        Schema::table('tags', function ($table) {
            $table->dateTime('moderated')->change();
        });
    }
}
