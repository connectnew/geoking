<?php

namespace App\Http\Controllers;

use App\Jobs\ScanLocationsJob;
use App\Location;
use App\ScanResult;
use App\User;

/**
 * Class ScanResultController
 * @package App\Http\Controllers
 */
class ScanResultController extends Controller
{
    public function report($id)
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var ScanResult $scanResult */
        $scanResult = ScanResult::query()
            ->where('location_id', $id)
            ->latest('created_at')
            ->get()->first();

        if ($scanResult instanceof ScanResult) {
            return response()->json($scanResult);
        }

        try {
            /** @var Location $location */
            $location = Location::query()
                ->where('id', $id)
                ->with('source')
                ->where('created_by', auth()->id())
                ->get()->first();

            ScanLocationsJob::dispatchNow($user, [$location], [$location->source]);

            /** @var ScanResult $scanResult */
            $scanResult = ScanResult::query()
                ->where('location_id', $id)
                ->latest('created_at')
                ->get()->first();

            return response()->json($scanResult);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Scan result for location not found.'], 404);
        }
    }
}