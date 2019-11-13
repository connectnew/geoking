<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationRenameIsConfirmed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('locations', static function (Blueprint $table) {
            $table->renameColumn('is_confermed', 'is_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('locations', static function (Blueprint $table) {
            $table->renameColumn('is_confirmed', 'is_confermed');
        });
    }
}
