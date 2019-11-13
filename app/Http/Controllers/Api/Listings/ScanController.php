<?php

namespace App\Http\Controllers\Api\Listings;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\ScanLocationsJob;
use App\Location;
use App\Mail\ScanResultMail;
use App\Objects\ScanEntity;
use App\Objects\ScanReportDetails;
use App\Services\ScanService;
use App\Source;
use App\User;
use Illuminate\Http\Request;
use Exception, RuntimeException;
use Illuminate\Support\Facades\Mail;
use SKAgarwal\GoogleApi\PlacesApi as GooglePlaces;
use Symfony\Component\HttpFoundation\Response;
use Zttp\Zttp;

/**
 * Class ScanController
 * @package App\Http\Controllers\Api\Listings
 */
class ScanController extends ApiController
{
    /**
     * @param ScanService $scanService
     * @param Request $request
     * @return Response
     */
    public function scan(ScanService $scanService, Request $request): Response
    {
        $googleClient = new GooglePlaces(config('google.developer_key'));

        $scanDetails = new ScanReportDetails();

        try {
            $res = [];
            $userEmail = $request->post('email');
            foreach ($request->post('locations', []) as $location) {
                try {
                    $entity = new ScanEntity();
                    $entity->setName($location['store_name']);
                    $entity->setPhone($location['store_phone']);
                    $entity->setCountry($location['country']?? '');
                    $entity->setProvince($location['province']?? '');
                    $entity->setCity($location['city']);
                    $entity->setAddress($location['store_address']);
                    $entity->setPostalCode($location['po_box']);
                    $entity->setWebSite($location['website'] ?? '');

                    // geo coding
                    $geoUrl = sprintf(
                        'https://maps.googleapis.com/maps/api/geocode/json?components=locality:%s|country:%s&key=%s',
                        $entity->getCity(),
                        $entity->getCountry(),
                        config('google.developer_key')
                    );
                    $geoCode = Zttp::get($geoUrl)->json();
                    $bounds = null;
                    if ($geoCode['status'] === 'OK') {
                        $bounds = $geoCode['results'][0]['geometry']['bounds'] ?? null;
                    }

                    $report = $scanService->googlePlacesScan($googleClient, $entity, $bounds);
                    $res[] = ['result' => $scanDetails->makeDetails($report, [ScanService::GOOGLE_MAPS_PLATFORM_API_NAME]), 'error' => null];
                } catch (RuntimeException $e) {
                    $res[] = ['result' => null, 'error' => $e->getMessage()];
                }
            }

            if (null !== ($pdf = $scanDetails->makePDF(count($res)))) {
                Mail::to($userEmail)->send(new ScanResultMail($pdf->output()));
            }

            return response()->json($res);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function scanOAuthLocations(Request $request): Response
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            $accounts = $user->accounts()->get();
            if ($accounts->isEmpty()) {
                return response()->json(['error' => 'Account required. Please added new account.'], 403);
            }

            /** @var Location[] $locations */
            $locations = Location::with('source')->has('source')->findMany($request->post());

            $_locations = [];
            $_sources = [];
            $c=0;

            foreach ($locations as $location) {
                $_locations[$c] = $location;
                $_sources[$c] = $location->source;
                $c++;
            }

            if ($c > 0) {
                dispatch_now((new ScanLocationsJob($user, $_locations, $_sources))->onQueue('scan_locations'));
                return response()->json(['message' => 'Thank you! Your scan is queued and you\'ll be notified after successful execution']);
            }

            return response()->json(['error' => 'No sources of truth for selected locations<br/><br/><a href="/source">Add new</a>'], 422);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
