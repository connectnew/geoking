<?php

namespace App;

use \Igaster\LaravelCities\Geo as GeoParent;
use \Illuminate\Support\Facades\Route;

/**
 * Class Geo
 * @package App
 */
class Geo extends GeoParent
{
    public static function ApiRoutes()
    {
        parent::ApiRoutes();

        Route::group(['prefix' => 'geo'], function () {
            Route::get('cities/{id}', '\App\Http\Controllers\Geo\GeoController@cities');
            Route::get('countries', '\App\Http\Controllers\Geo\GeoController@countries');
        });

    }
}
