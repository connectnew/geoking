<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewsAddCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('domain_id')->nullable(0)->after('responded'); /*business sector*/
            $table->integer('category_id')->nullable(0)->after('domain_id');
            $table->integer('language_id')->nullable(0)->after('category_id');
            $table->tinyInteger('positive')->nullable()->after('language_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['domain_id', 'category_id', 'language_id', 'positive']);
        });
    }
}
