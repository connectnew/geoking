<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JsonStatsDataPublishIndicator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
             $table->json('stats_data')->nullable();
             $table->boolean('is_confermed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('locations', function (Blueprint $table) {
             $table->json('stats_data')->drop();
             $table->boolean('is_confermed')->drop();
        });
    }
}
