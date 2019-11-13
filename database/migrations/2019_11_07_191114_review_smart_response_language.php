<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewSmartResponseLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_smart_response', function (Blueprint $table) {
            $table->renameColumn('langauge_id', 'language_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_smart_response', function (Blueprint $table) {
            $table->renameColumn('language_id', 'langauge_id');
        });
    }
}
