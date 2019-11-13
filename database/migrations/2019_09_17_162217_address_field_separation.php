<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddressFieldSeparation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('accounts', static function (Blueprint $table) {
            $table->string('country', 255)->after('phone');
            $table->string('province', 255)->nullable(true)->after('country');
            $table->string('city', 255)->after('province');
            $table->string('postal_code', 100)->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('accounts', static function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
        });
    }
}
