<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalconstantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('globalconstants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longtext('description');
            $table->string('value', 255);
            $table->string('type', 255);
            $table->timestamps();
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('globalconstants');
    }
}
