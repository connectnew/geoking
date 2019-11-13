<?php

use App\Traits\Blueprints\BlueprintCreatedAndUpdatedByForeignKeys;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScanResultsTable extends Migration
{
    use BlueprintCreatedAndUpdatedByForeignKeys;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('scan_results', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('location_id');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->json('report_details');
            $table->decimal('score', 10, 2);

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
        Schema::dropIfExists('scan_results');
    }
}
