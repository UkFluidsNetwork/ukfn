<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiletypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filetypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('shortname');
        });
        // populate
        DB::table('filetypes')->insert(
            [
                [
                    'name' => 'Notes',
                    'shortname' => 'Notes'
                ],
                [
                    'name' => 'Code',
                    'shortname' => 'Code'
                ],
                [
                    'name' => 'Slides',
                    'shortname' => 'Slides'
                ],
                [
                    'name' => 'Audio clip',
                    'shortname' => 'Audio'
                ],
                [
                    'name' => 'Video clip',
                    'shortname' => 'Video'
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
        Schema::drop('filetypes');
    }
}
