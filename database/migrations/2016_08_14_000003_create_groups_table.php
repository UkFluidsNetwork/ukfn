<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create
      Schema::create('groups', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('name', 255);
          $table->boolean('deleted')->default(false);
      });
      // populate
      DB::table('groups')->insert(
        [
          [
            'name' => 'Administrator',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
          ],
          [
            'name' => 'Moderator',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
          ],
          [
            'name' => 'Member',
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
        Schema::drop('groups');
    }
}
