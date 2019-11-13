<?php

namespace App\Http\Controllers;

use App\Jobs\SyncUserListing;
use App\User;
use App\OAuth;
use Illuminate\Http\Request;
use App\Location;
use Google_Client;
use Illuminate\Support\Facades\Log;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
   public function show($id,Google_Client $gClient)
    {
        $user = auth()->user();
        //dd($this->raw_data['name']);

        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();

        if ($accessToken->isEmpty()) {
            return response(403)->json(['message'=>"Oauth token required. Please Connect your Google account."]);
        }

        /** @var OAuth $oauth */
        $oauth = $accessToken->first();
        $oauth->configureGoogle($gClient);
        
        $gmb = new GoogleMyBusiness($gClient);
        
        $location = Location::query()
            ->where('id', $id)
            ->where('created_by', auth()->id())
            ->withCount('source')
            ->get()->first();

        //$location->rating = $location ? $location->reviews()->get()->average('rating') : 0;

        if (!($location instanceof Location)) {
            return response()->json(['error' => 'Location not found.'], 404);
        }

        try {
            $location->photos = $gmb->accounts_locations_media->listAccountsLocationsMedia($location->raw_data['name'])->toSimpleObject();
        } catch (\Google_Service_Exception $exception) {
            Log::error($exception->getMessage(), [
                'LocationId' => $location->id,
                'Title' => $location->title,
                'GoogleLocationId' => $location->raw_data['name']
            ]);
        }
        //dd($photos);
        return view('pages.listings.location-edit')->with([ 'location' => $location]);
    }

    public function refresh()
    {
        /** @var User $user */
        $user = Auth::user();
        SyncUserListing::dispatchNow($user->id);

        return redirect('manage-locations');
    }
}
