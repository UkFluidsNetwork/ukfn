<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestionsTable extends Migration
{
    /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('suggestions', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('name');
          $table->string('email');
          $table->string('institution');
          $table->string('suggestion');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::drop('suggestions');
  }
}
