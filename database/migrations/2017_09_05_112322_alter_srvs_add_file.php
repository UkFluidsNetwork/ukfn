<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSrvsAddFile extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('srvs', function ($table) {
            $table->string('reporturl')->nullable()->after('department');
            $table->dropColumn('report');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('srvs', function ($table) {
            $table->dropColumn('file_id');
            $table->text('report')->nullable()->after('visiting');
        });
    }
}

