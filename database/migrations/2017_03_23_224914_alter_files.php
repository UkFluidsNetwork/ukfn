<?php
use Illuminate\Database\Migrations\Migration;

class AlterFiles extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function ($table) {
            $table->integer('tutorial_id')->unsigned()->nullable()->after('user_id');
            $table->integer('filetype_id')->unsigned()->nullable()->after('tutorial_id');
            $table->softDeletes();

            $table->foreign('tutorial_id')->references('id')->on('tutorials');
            $table->foreign('filetype_id')->references('id')->on('filetypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function ($table) {
            $table->dropColumn('tutorial_id');
            $table->dropColumn('filetype_id');
            $table->dropColumn('created_at');
        });
    }
}
