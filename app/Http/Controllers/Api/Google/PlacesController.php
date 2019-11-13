<?php

namespace App\Http\Controllers\Api\Google;

use App\Http\Controllers\Api\ApiController;
use Igaster\LaravelCities\Geo;
use GuzzleHttp\Client;
use Zttp\Zttp;



class PlacesController extends ApiController
{

	public function businessesAutocomplete($query){
		$places = $this->gPlaces->placeAutocomplete($query, [
            'sessiontoken' => sessionId(),
            'types' => 'establishment'
		]);
		return response()->json($places->all());

	}

	public function placesAutocomplete($query){
		$response = Zttp::get('https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.$query.'&key='.config('google.developer_key').'&sessiontoken='.sessionId().'&types=geocode')->json();
		return response()->json($response);
	}

	public function placeDetails($place_id){
		$response = Zttp::get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.$place_id.'&key='.config('google.developer_key').'&sessiontoken='.sessionId().'&types=geocode')->json();
		return response()->json($response);
	}

	public function geoCodePlace($query){
		$response = Zttp::get('https://maps.googleapis.com/maps/api/geocode/json?address='.$query.'&key='.config('google.developer_key').'&sessiontoken='.sessionId().'&types=geocode')->json();
		return response()->json($response);
	}
   
}
