<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->longtext('description')->nullable();
            $table->longtext('link')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
        // populate
        DB::table('news')->insert(
            [
                [
                    'title' => 'SIG',
                    'description' => 'First call for proposals for Special Interest Groups (SIGs)',
                    'link' => '/sig',
                    'user_id' => 1,
                    'created_at' => date("Y-m-d H:i:s", strtotime("2016-09-01 00:00:00")),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'title' => 'SRV',
                    'description' => 'Rolling call for proposals for Short Research Visits (SRVs)',
                    'link' => '/srv',
                    'user_id' => 1,
                    'created_at' => date("Y-m-d H:i:s", strtotime("2016-09-01 00:00:00")),
                    'updated_at' => date("Y-m-d H:i:s")
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
        Schema::drop('news');
    }
}
