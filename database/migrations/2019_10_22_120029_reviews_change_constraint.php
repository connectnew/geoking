<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewsChangeConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $indexesFound = $sm->listTableIndexes('reviews');
        Schema::table('reviews', function (Blueprint $table) use ($indexesFound) {
            if(array_key_exists('reviews_source_name_source_key_unique', $indexesFound)) {
                $table->dropUnique('reviews_source_name_source_key_unique');
            }
            $table->unique(['location_id', 'source_name', 'source_key'], 'reviews_location_source_key_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign('reviews_location_id_foreign');
            $table->dropUnique('reviews_location_source_key_unique');
            $table->unique(['source_name', 'source_key']);
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');
        });
    }
}
