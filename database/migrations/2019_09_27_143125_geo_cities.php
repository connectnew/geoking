<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GeoCities extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('geo_cities')) {
			Schema::create('geo_cities', function (Blueprint $table) {
				$table->increments('id');

				$table->char('name', 60);

				$table->text('alternames');

				$table->char('country', 2);
				$table->char('level', 10);

				$table->bigInteger('population');

				$table->decimal('lat', 9, 6);
				$table->decimal('long', 9, 6);
			});
		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geo_cities');
	}
}
