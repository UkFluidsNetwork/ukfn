<?php

use Illuminate\Database\Migrations\Migration;

class AlterAggregators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aggregators', function ($table) {
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
