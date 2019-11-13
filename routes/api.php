<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
\App\Geo::ApiRoutes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')->prefix('v1')->group(function () {
    Route::get('/businesses/search/{query}', 'Google\PlacesController@businessesAutocomplete');
    Route::get('/places/search/{query}', 'Google\PlacesController@placesAutocomplete');
    Route::get('/places/geocode/{query}', 'Google\PlacesController@geoCodePlace')->where('query', '.*');
    Route::get('/places/{place_id}/details', 'Google\PlacesController@placeDetails');
    Route::post('/image/listing/upload','ImageUploadController@upload');
});
