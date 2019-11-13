<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableStateAndZip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function(Blueprint $table)
        {
            $table->string('state', 255)->nullable()->change();
            $table->string('zip', 100)->nullable()->change();
            $table->string('website', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('locations', function(Blueprint $table)
        {
            $table->string('state', 255)->change();
            $table->string('zip', 100)->change();
            $table->string('website', 255)->change();
        });
    }
}
