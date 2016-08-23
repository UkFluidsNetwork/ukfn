<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('surname');
        $table->string('email')->unique();
        $table->string('password');
        $table->integer('title_id')->unsigned();
        $table->integer('group_id')->unsigned();
        $table->integer('department_id')->unsigned()->nullable();
        $table->rememberToken();
        $table->timestamps();

        $table->foreign('title_id')->references('id')->on('titles');
        $table->foreign('group_id')->references('id')->on('groups');
        $table->foreign('department_id')->references('id')->on('departments');
      });
      // populate
      DB::table('users')->insert(
        [
          [
            'name' => 'Javier',
            'surname' => 'Arias',
            'email' => 'ja573@cam.ac.uk',
            'password' => bcrypt("password"),
            'title_id' => 3,
            'group_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
          ],
          [
            'name' => 'Robert',
            'surname' => 'Barczyk',
            'email' => 'robert@barczyk.net',
            'password' => bcrypt("password"),
            'title_id' => 3,
            'group_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
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
        Schema::drop('users');
    }
}
