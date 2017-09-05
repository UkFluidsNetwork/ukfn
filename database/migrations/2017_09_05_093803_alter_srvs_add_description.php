<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSrvsAddDescription extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('srvs', function ($table) {
            $table->string('name')->nullable()->after('institution_id');
            $table->string('visitor')->nullable()->after('name');
            $table->string('department')->nullable()->after('visitor');
            $table->text('visiting')->nullable()->after('department');
            $table->text('report')->nullable()->after('visiting');
            $table->integer('user_id')->unsigned()->nullable()->change();
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
            $table->dropColumn('name');
            $table->dropColumn('visitor');
            $table->dropColumn('department');
            $table->dropColumn('visiting');
            $table->dropColumn('report');
        });
    }
}

