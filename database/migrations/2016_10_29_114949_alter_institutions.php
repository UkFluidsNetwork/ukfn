<?php
use Illuminate\Database\Migrations\Migration;

class AlterInstitutions extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutions', function ($table) {
            $table->string('url', 255)->nullable()->after('institutiontype_id');
            $table->dropForeign('institutions_address_id_foreign');
            $table->dropColumn('address_id');
        });

        Schema::drop('addresses');

        // populate institutiontypes
        DB::table('institutiontypes')->insert([['name' => 'academia'], ['name' => 'industry']]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function ($table) {
            $table->dropColumn('url');
        });
    }
}
