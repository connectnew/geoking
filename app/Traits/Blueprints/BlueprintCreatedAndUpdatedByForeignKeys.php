<?php

namespace App\Traits\Blueprints;

use Illuminate\Database\Schema\Blueprint;

trait BlueprintCreatedAndUpdatedByForeignKeys
{
    private static function addCreatedAndUpdatedBy(Blueprint $table, string $created_by = 'created_by', string $updated_by = 'updated_by') {

        $table->unsignedInteger($created_by);
        $table->unsignedInteger($updated_by);

        $table->foreign($created_by)
            ->references('id')
            ->on('users')
            ->onDelete('restrict');

        $table->foreign($updated_by)
            ->references('id')
            ->on('users')
            ->onDelete('restrict');
    }
}
