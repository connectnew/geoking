<?php

namespace App\Http\Controllers;

use App\OAuth;
use App\User;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Category;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Location;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_PostalAddress;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Accounts_Resource;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Notifications;
use Throwable;
use App\Jobs\SyncUserListing;

class Integrations extends Controller
{
    public function index()
    {
        return view('pages.settings.integrations', ['category'=>'settings', 'routeName'=>'integrations']);
    }

    // @todo remove
    public function testGoogle(Google_Client $client, Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
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
        $accounts = $gmb->accounts->listAccounts()->toArray();

//        $nots = $gmb->accounts->getNotifications($accounts->current()['name']);

        $nts = new Google_Service_MyBusiness_Notifications();
        // $nts->setName($accounts->current()['name']);  <- this is ignored as per https://developers.google.com/my-business/reference/rest/v4/Notifications
        $nts->setNotificationTypes(['GOOGLE_UPDATE', 'UPDATED_LOCATION_STATE', 'NEW_REVIEW', 'UPDATED_REVIEW', 'NEW_CUSTOMER_MEDIA', 'NEW_QUESTION', 'UPDATED_QUESTION', 'NEW_ANSWER', 'UPDATED_ANSWER']);
        $nts->setTopicName("projects/oceanic-grin-249712/topics/my-topic");  // <- https://monosnap.com/direct/EuHyJaojoswlGHaG7LJlnmeA4IZp13

        $updnots = $gmb->accounts->updateNotifications($accounts->current()['name'] . "/notifications", $nts);  // <- https://developers.google.com/my-business/reference/rest/v4/accounts/updateNotifications

        dd($gmb->accounts->getNotifications($accounts->current()['name'] . "/notifications"));
        //$accres = new Google_Service_MyBusiness_Accounts_Resource();
        //$accres->get($accounts->current()['name']);
        //$updnots = $accres->updateNotifications($accounts->current()['name'],$nts);
        //dd($updnots);
        // get locations list for the first account
        $locations = $gmb->accounts_locations->listAccountsLocations($accounts->current()['name']);

        // autocomplete categories
        $gmb->categories->listCategories(['regionCode' => 'CA', 'languageCode' => 'en', 'searchTerm' => 'dent']);

        // create location - minimal set of fields
        $primaryCat = new Google_Service_MyBusiness_Category();
        $primaryCat->setCategoryId('gcid:dental_clinic');
        $primaryCat->setDisplayName('Dental clinic');

        $address = new Google_Service_MyBusiness_PostalAddress();
        $address->setRegionCode('CA');
        $address->setLanguageCode('en');
        $address->setPostalCode('R3C 3M2');
        $address->setLocality('Winnipeg');
        // Use Google_Model::NULL_VALUE if you need to setup
        $address->setAdministrativeArea('Manitoba');
        $address->setAddressLines('66 Stapon Rd');

        $loc = new Google_Service_MyBusiness_Location();
        $loc->setLocationName('Shelly The Dentist');
        $loc->setWebsiteUrl('https://dental.com');
        $loc->setPrimaryCategory($primaryCat);
        $loc->setLanguageCode('en');
        $loc->setAddress($address);

        // $accres = new Google_Service_MyBusiness_Accounts_Resource();
        // $accres = $accres->get($accounts->current()['name']);
        //     \Log::info($accres);

        $r = $gmb->accounts_locations->create($accounts->current()['name'], $loc, ['validateOnly' => false, 'requestId' => sessionId()]);
        //return $r;

        dd($r);
    }

    public function googleStep2(Google_Client $client, Request $request)
    {
        Log::debug('Integrations@googleStep2', [$request->input()]);

        if($request->query('error') === 'access_denied') {
            // user clicks on `cancel` at google oauth page
            return redirect()->route('integrations')->withErrors(['msg' => 'Google is not connected! Integration required']);
        }

        try {
            $request->validate(['code' => 'required']);

            // Exchange the one-time authorization code for an access token
            $accessToken = $client->fetchAccessTokenWithAuthCode($request->input('code'));

            /** @var User $user */
            $user = Auth::user();

            if ($user === null) {
                dd($request);
            }

            $existing = $user->oauth()->where('provider', OAuth::GOOGLE)->get();

            if ($existing->isEmpty()) {
                $oauth = new OAuth();
                $oauth->user_id = $user->id;
                $oauth->token = $accessToken;
            } else {
                /** @var OAuth $oauth */
                $oauth = $existing->first();
            }

            // store $accessToken to user database
            $oauth->saveOrFail();
            $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();
            $oauth = $accessToken->first();
            $oauth->configureGoogle($client);
            $gmb = new GoogleMyBusiness($client);
            $accounts = $gmb->accounts->listAccounts();
            $nts = new Google_Service_MyBusiness_Notifications();
            $nts->setNotificationTypes(['GOOGLE_UPDATE', 'UPDATED_LOCATION_STATE', 'NEW_REVIEW', 'UPDATED_REVIEW', 'NEW_CUSTOMER_MEDIA', 'NEW_QUESTION', 'UPDATED_QUESTION', 'NEW_ANSWER', 'UPDATED_ANSWER']);
            $nts->setTopicName("projects/oceanic-grin-249712/topics/my-topic");
            $updnots = $gmb->accounts->updateNotifications($accounts->current()['name'] . "/notifications", $nts);
            SyncUserListing::dispatchnow($user->id);

            if (request()->session()->has('form') && request()->session()->get('current-step')) {
                $form = request()->session()->get('form');
                $currentStep = request()->session()->get('current-step');
                return redirect()->route('profile', ['currentStep' => $currentStep]);
            } else {
                return redirect()->route('integrations')->with('msg', 'Google connected!');
            }

        } catch (Throwable $e) {
            dump($e);
            return response('Bad request', 400);
        }
    }

    public function googleStep1(Google_Client $client)
    {
        // Generate a URL to request access from Google's OAuth 2.0 server:
        $authUrl = $client->createAuthUrl();
        // Redirect the user to Google's OAuth server
        return redirect($authUrl);
    }

    public function saveSession()
    {
        request()->session()->put('form', request()->form);
        request()->session()->put('current-step', request()->currentStep);
    }
}
