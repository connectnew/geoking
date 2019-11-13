<?php

namespace App\Http\Controllers\Geo;

use \Igaster\LaravelCities\GeoController as GeoControllerParent;
use \Illuminate\Support\Facades\DB as DB;
use \App\Geo as Geo;

/**
 * Class GeoController
 * @package App\Http\Controllers\Geo
 */
class GeoController extends GeoControllerParent
{

	public function countries()
	{
		return parent::countries()->sortBy('name', \SORT_NATURAL)->values();
	}


	public function cities(string $countryCode)
	{

		$query = DB::table('geo_cities')->where('country',$countryCode)->groupby('name')->orderby('name')->get()->toArray();
		return $query;
	}

}
