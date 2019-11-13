<?php

namespace App\Http\Controllers\Api\Google;

use App\Http\Controllers\Api\ApiController;
use Igaster\LaravelCities\Geo;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use Google_Client;
use Illuminate\Http\Request;
use App\OAuth;
use App\Location;
use Illuminate\Support\Facades\Log;
use Google_Service_Exception;
use Zttp\Zttp;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Category;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Metadata;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_PostalAddress;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Location;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_GoogleLocation;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_LatLng;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_PhoneInput;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Openinfo;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_AdWordsLocationExtensions;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_BusinessHours;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Profile;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Places;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_ServiceAreaBusiness;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Attribute;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_SpecialHours;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_MediaItem;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_LocationAssociation;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_StartUploadMediaItemDataRequest;


class DataController extends ApiController
{


    public function locationsList($type = "all")
    {  
    	$per_page =  request()->per_page ? (int) request()->per_page: 10;
        /** @var User $user */
        $user_id =auth()->id();
        $locations = Location::with('latestScanResult')
            ->withCount([
                'reviews',
                'reviews as pending_reviews_count' => static function (Builder $query) {
                    $query->where('responded', false);
                }
            ])
            ->where('created_by',$user_id);
        if($type == "all"){
        	$locations = $locations;
        }
        elseif($type == "confirmed"){
        	$locations = $locations->where('is_confirmed',true);
        }
        else{
        	$locations = $locations->where('is_confirmed',false);
        }

        if(request()->paginate) {
            $locations = $locations->paginate($per_page);
        } else {
            $locations = $locations->get();
        }
        return response()->json($locations);
     
    }

    public function test(Google_Client $client)
    {
        $user = auth()->user();
        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();

        if ($accessToken->isEmpty()) {
            // need to get access token
            return redirect()->route('integrations')->withErrors(['msg' => 'Integration required']);
        }

        /** @var OAuth $oauth */
        $oauth = $accessToken->first();
        $oauth->configureGoogle($client);

        $gmb = new GoogleMyBusiness($client);
        // get accounts list
        $accounts = $gmb->accounts->listAccounts(['type'=> 'LOCATION_GROUP']);
        
    }
    public function categoriesAutocomplete(Google_Client $gClient, $query)
    {
        /** @var User $user */
        $user =auth()->user();
        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();

        if ($accessToken->isEmpty()) {
            // need to get access token
            return response(403)->json(['message'=>"Oauth token required. Please Connect your Google account."]);
        }

        /** @var OAuth $oauth */
        $oauth = $accessToken->first();
        $oauth->configureGoogle($gClient);

        $gmb = new GoogleMyBusiness($gClient);
        // get accounts list
        try{
        $categories = $gmb->categories->listCategories(['regionCode' => 'CA', 'languageCode' => 'en', 'searchTerm' => $query]);
        }
    	catch(Exception $e){
    		return response(500)->json($e->getMessage());
    	}

        return response()->json($categories->getCategories());
    }

    public function createListing(Google_Client $gClient){
    	$data = request()->all();
    	$user = auth()->user();

        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();

        if ($accessToken->isEmpty()) {
            return response(403)->json(['message'=>"Oauth token required. Please Connect your Google account."]);
        }

        /** @var OAuth $oauth */
        $oauth = $accessToken->first();
        $oauth->configureGoogle($gClient);
        
        $gmb = new GoogleMyBusiness($gClient);

        try{
        $accounts = $gmb->accounts->listAccounts();

    	$primaryCat = new Google_Service_MyBusiness_Category();
        $primaryCat->setCategoryId($data['category']['categoryId']);
        $primaryCat->setDisplayName($data['category']['displayName']);

        $address = new Google_Service_MyBusiness_PostalAddress();
        $address->setRegionCode($data['postal_address']['country_code']);
        $address->setLanguageCode('en');
        if(isset($data['postal_address']['postal_code']) && $data['postal_address']['postal_code'] != '' && $data['postal_address']['postal_code'] != null){
            $address->setPostalCode($data['postal_address']['postal_code']);
        }
        if(isset($data['postal_address']['province']) && $data['postal_address']['province'] != '' && $data['postal_address']['province'] != null){
            $address->setAdministrativeArea($data['postal_address']['province']);
        }
        $address->setLocality($data['postal_address']['city']);
       
        $address->setAddressLines($data['postal_address']['address']);

        $latlng = new Google_Service_MyBusiness_LatLng();
        $latlng->setLatitude($data['lat']);
        $latlng->setLongitude($data['lng']);


        $loc = new Google_Service_MyBusiness_Location();
        $loc->setLocationName($data['name']);
        $loc->setWebsiteUrl($data['website_url']);
        $loc->setPrimaryCategory($primaryCat);
        $loc->setPrimaryPhone($data['phone']);
        $loc->setLatlng($latlng);
        $loc->setLanguageCode('en');
        $loc->setAddress($address);

       

        $r = $gmb->accounts_locations->create($accounts->current()['name'], $loc, ['validateOnly' => false, 'requestId' => sessionId()]);

        $locationLocal = new Location;
        $locationLocal->title =  $loc->getLocationName();
        $locationLocal->google_account_id =  $accounts->current()['name'];
        $locationLocal->phone = $loc->getPrimaryPhone();//$loc->getPhoneNumber();
        $locationLocal->website = $loc->getWebsiteUrl();
        $locationLocal->country = $address->getRegionCode();
        $locationLocal->address = $address->getAddressLines();
        $locationLocal->street = $address->getAddressLines();
        $locationLocal->city = $address->getLocality();
        $locationLocal->state = $address->getAdministrativeArea();
        $locationLocal->zip = $address->getPostalCode();
        $locationLocal->latitude = $latlng->getLatitude();
        $locationLocal->longitude = $latlng->getLongitude();
        $locationLocal->raw_data = $r->toSimpleObject();
        $save = $locationLocal->save();
        }
    	catch(Exception $e){
    		return response(500)->json($e->getMessage());
    	}
       
        return response()->json($r);
    }

     public function deleteListing(Google_Client $gClient, $locationid){
        $location = Location::findOrFail($locationid);
        $user = auth()->user();
        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();
        $oauth = $accessToken->first();
        $oauth->configureGoogle($gClient);
        $gmb = new GoogleMyBusiness($gClient);
        if(gettype($location->raw_data) == "array" ){
            $accounts = $gmb->accounts->listAccounts();
            try{
                $loc = $gmb->accounts_locations->delete($location->raw_data['name']);
            }
            catch(Google_Service_Exception $e){
                Log::error($e->getErrors());
            }
        }
        $location->delete();
        return response('',202);
     }

      public function patchListing(Google_Client $gClient, $locationid){
        
        $data = request()->all();
        $location = Location::findOrFail($locationid);
        $user = auth()->user();
        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();
        $oauth = $accessToken->first();
        $oauth->configureGoogle($gClient);
        $gmb = new GoogleMyBusiness($gClient);
        if(gettype($location->raw_data) == "array"){
        $accounts = $gmb->accounts->listAccounts();
        $gLocation = $gmb->accounts_locations->get($location->raw_data['name']);


        $address = new Google_Service_MyBusiness_PostalAddress();
        if(isset($data['address']))
        {
        $address->setRegionCode($data['address']['regionCode']);
        $address->setLanguageCode('en');
        if(isset($data['address']['postalCode']) && $data['address']['postalCode'] !="" && $data['address']['postalCode'] != null){
             $address->setPostalCode($data['address']['postalCode']);
             $location->zip = $data['address']['postalCode'];
        }
        if(isset($data['address']['administrativeArea']) && $data['address']['administrativeArea'] !="" && $data['address']['administrativeArea'] != null){
             $address->setAdministrativeArea($data['address']['administrativeArea']);
             $location->state = $data['address']['administrativeArea'];
        }
        $address->setLocality($data['address']['locality']);
        $address->setAddressLines($data['address']['addressLines']);
        }


        $hours = new Google_Service_MyBusiness_BusinessHours();
        if(isset($data['regularHours']['periods']) && $data['regularHours']['periods'] != [])
        {
            $hours->setPeriods($data['regularHours']['periods']);
        }
         $gLocation->setRegularHours($hours);

        if(isset($data['primaryPhone'])){
             $gLocation->setPrimaryPhone($data['primaryPhone']);
        }
        if(isset($data['websiteUrl'])){
             $gLocation->setWebsiteUrl($data['websiteUrl']);
        }
        if(isset($data['profile'])){
            $profile = new Google_Service_MyBusiness_Profile();
            $profile->setDescription($data['profile']['description']);
            $gLocation->setProfile($profile);
        }
        if(isset($data['storeCode']) && $data['storeCode'] != ''){
            $gLocation->setStoreCode($data['storeCode']);
        }
        if(isset($data['serviceArea']['places']['placeInfos'])){
            if(isset($data['serviceArea']['places']['placeInfos'][0])){
                $places  = new Google_Service_MyBusiness_Places();
                $places->setPlaceInfos($data['serviceArea']['places']['placeInfos']);
                $serviceArea = new Google_Service_MyBusiness_ServiceAreaBusiness();
                $serviceArea->setPlaces($places);
                $serviceArea->setBusinessType('CUSTOMER_AND_BUSINESS_LOCATION');
            }
            
            $gLocation->setServiceArea($serviceArea);

        }


        if(isset($data['attributes'][0])){
            $attribute = new Google_Service_MyBusiness_Attribute();
            $attribute->setAttributeId($data['attributes'][0]['attributeId']);
            $attribute->setValueType($data['attributes'][0]['valueType']);
            $attribute->setValues($data['attributes'][0]['values']);
            $gLocation->setAttributes($attribute);
        }

         if(isset($data['address']['latlng'])){
            $latlng = new Google_Service_MyBusiness_LatLng();
            $latlng->setLatitude($data['address']['latlng']['latitude']);
            $latlng->setLongitude($data['address']['latlng']['latitude']);
            $gLocation->setLatlng($latlng);
        }

         if(isset($data['photos'])){
             $photos = $this->createGooglePhotos($data['photos'],$gmb,$location->raw_data['name'],$oauth->token['access_token']);

         }

        $specialPeriods = new Google_Service_MyBusiness_SpecialHours();
        if(isset($data['specialHours']['specialHourPeriods']) && $data['specialHours']['specialHourPeriods'] != []){
           
            $specialPeriods->setSpecialHourPeriods($data['specialHours']['specialHourPeriods']);
            
        }
        $gLocation->setSpecialHours($specialPeriods);

        $gLocation->setAddress($address);
        $gLocation->setMetadata(new Google_Service_MyBusiness_Metadata());
        $gLocation->setOpeninfo(new Google_Service_MyBusiness_Openinfo());
        $gLocation->setAdWordsLocationExtensions(new Google_Service_MyBusiness_AdWordsLocationExtensions());
        try{
            $newGLocation = $gmb->accounts_locations->patch($location->raw_data['name'],$gLocation,['validateOnly' => false,'updateMask' => '','attributeMask'=>'']);
            $location->raw_data = $newGLocation->toSimpleObject();
            $location->save();
        }
        catch(Exception $e){
            return response()->json($e);
        }
        }
        return response('',201);
     }

     public function createGooglePhotos($photos,$gmb,$loc_name,$token){
        $items = [];
        foreach($photos as $key => $photo){
            $file = config('app.url').'/storage'.$photo['url'];

            $request = new Google_Service_MyBusiness_StartUploadMediaItemDataRequest();
            $gfile = $gmb->accounts_locations_media->startUpload($loc_name,$request);
        
            $association = new Google_Service_MyBusiness_LocationAssociation();
            $association->setCategory('INTERIOR');
            $media = new Google_Service_MyBusiness_MediaItem();
            $media->setSourceUrl($file);
            //$media->setMediaFormat('PHOTO');
            $media->setLocationAssociation($association);
           //$result = $gmb->accounts_locations_media->create($loc_name,$media);
            $items += [$key=>$gmb->accounts_locations_media->create($loc_name,$media)];
        }
        return $items;
     }

}
