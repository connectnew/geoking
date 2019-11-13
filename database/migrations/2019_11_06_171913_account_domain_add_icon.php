<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountDomainAddIcon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*business sector*/
        Schema::table('account_domains', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('description');
        });

        Schema::table('review_category', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*business sector*/
        Schema::table('account_domains', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::table('review_category', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
