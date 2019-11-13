<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Blueprints\BlueprintCreatedAndUpdatedByForeignKeys;

/**
 * Class CreateReviewTable
 */
class CreateReviewTable extends Migration
{
    use BlueprintCreatedAndUpdatedByForeignKeys;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('location_id');
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->string('source_name', 32);
            $table->string('source_key');
            $table->unique(['source_name', 'source_key']);

            $table->boolean('reviewer_is_anonymous')->nullable()->default(0);
            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_photo_url')->nullable();

            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('comment')->nullable();

            $table->boolean('responded')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
}
