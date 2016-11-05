<?php
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddOrcidid extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('orcidid', 255)->nullable()->after('department_id');
            $table->string('url', 255)->nullable()->after('orcidid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('orcidid');
            $table->dropColumn('url');
        });
    }
}
