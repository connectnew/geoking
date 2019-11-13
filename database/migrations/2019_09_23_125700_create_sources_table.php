<?php

use App\Traits\Blueprints\BlueprintCreatedAndUpdatedByForeignKeys;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSourcesTable
 */
class CreateSourcesTable extends Migration
{
    use BlueprintCreatedAndUpdatedByForeignKeys;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sources', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('restrict');

            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('country', 255);
            $table->string('province', 255)->nullable(true);
            $table->string('city', 255);
            $table->string('address', 255);
            $table->string('postal_code', 100);
            $table->string('website', 255);

            $table->unsignedInteger('external_id');
            $table->unique(['account_id', 'external_id']);

            $table->string('gmb_place_id', 255)->nullable()->default(null);

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
        Schema::dropIfExists('sources');
    }
}
