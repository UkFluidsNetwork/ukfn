<?php

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create the table
        Schema::create('titles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 20);
            $table->string('shortname', 20);
            $table->boolean('deleted')->default(false);
        });
        // populate
        DB::table('titles')->insert(
            [
                [
                    'name' => 'Doctor',
                    'shortname' => 'Dr.',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Professor',
                    'shortname' => 'Pr.',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Mister',
                    'shortname' => 'Mr.',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Miss',
                    'shortname' => 'Ms.',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Mistress',
                    'shortname' => 'Mrs.',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'name' => 'Sir',
                    'shortname' => 'Sir',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
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
        Schema::drop('titles');
    }
}
