<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SKAgarwal\GoogleApi\PlacesApi as GooglePlaces;
use Zttp\Zttp;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $gPlaces;
    public $zttp;

    public function __construct(){
    	$this->gPlaces = new GooglePlaces(config('google.developer_key'));
    	$this->zttp = new Zttp;

    }

    
}
