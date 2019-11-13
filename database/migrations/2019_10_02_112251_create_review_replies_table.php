<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Blueprints\BlueprintCreatedAndUpdatedByForeignKeys;

class CreateReviewRepliesTable extends Migration
{
    use BlueprintCreatedAndUpdatedByForeignKeys;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('review_replies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('review_id');
            $table->foreign('review_id')
                ->references('id')
                ->on('reviews')
                ->onDelete('restrict');

            $table->string('comment', 4096);

            self::addCreatedAndUpdatedBy($table);
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
        Schema::dropIfExists('review_replies');
    }
}
