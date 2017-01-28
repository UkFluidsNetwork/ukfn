<?php
use Illuminate\Database\Migrations\Migration;

class AlterSigAddPictures extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sigs', function ($table) {
            $table->text('shortdescription')->nullable()->after('description');
            $table->text('twitterurl')->nullable()->after('shortdescription');
            $table->text('bigimage')->nullable()->after('twitterurl');
            $table->text('smallimage')->nullable()->after('bigimage');
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
            $table->dropColumn('shortdescription');
            $table->dropColumn('twitterurl');
            $table->dropColumn('bigimage');
            $table->dropColumn('smallimage');
        });
    }
}
