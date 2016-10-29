<?php
use Illuminate\Database\Migrations\Migration;

class AlterTagtypesAddName extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagtypes', function ($table) {
            $table->text('name')->after('id');
        });

        // populate
        DB::table('tagtypes')->insert(
            [
                [
                    'name' => 'Sub-disciplines'
                ],
                [
                    'name' => 'Application Area'
                ],
                [
                    'name' => 'Techniques'
                ],
                [
                    'name' => 'Facilities'
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagtypes', function ($table) {
            $table->dropColumn('name');
        });
    }
}
