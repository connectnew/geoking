<?php

namespace App\Http\Controllers;

use App\Location;
use App\OAuth;
use App\Review;
use App\Services\LocationsInsightsService;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;

/**
 * Class LocationsAnalyticsController
 * @package App\Http
 */
class LocationsAnalyticsController extends Controller
{
    private const LAST_MONTHS_COUNT = 12;
    private const LOCATION_STATUS_VERIFIED = 'Verified';
    private const LOCATION_STATUS_UNVERIFIED = 'Unverified';

    private const PERIOD_ONE_MONTH = 'last 30 days';
    private const PERIOD_THREE_MONTHS = 'last 3 month';
    private const PERIOD_ONE_YEAR = 'last year';
    private const PERIOD_USER_CHOICE = 'choose period';

    private const SOURCES = ['google'];

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function locations(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            // query
            $locations = $this->getLocationsQueryByRequest($user, $request)
                ->with('latestScanResult')
                ->withCount('reviews')
                ->get();

            return response()->json([
                'locations' => $locations,
                'totals' => $this->profileScore($locations)
            ]);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function scoreBySite(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $result = [];

        try {
            // query
            $locations = $this->getLocationsQueryByRequest($user, $request)->get(['id']);
            $locationIds = $locations->pluck('id')->toArray();
            $locationIds[] = 0;

            $reviewList = Review::query()
                ->whereIn('location_id', $locationIds)
                ->get();

            $now = CarbonImmutable::now();
            $predData = [];
            // per month
            for ($i=0; $i<self::LAST_MONTHS_COUNT; $i++) {
                /** @var CarbonImmutable $month */
                $month = $now->subMonthsWithoutOverflow(self::LAST_MONTHS_COUNT-$i-1);
                $startOfMonth = $month->startOfMonth()->format('Y-m-d H:i:s');
                $endOfMonth = $month->endOfMonth()->format('Y-m-d H:i:s');
                $reviewListByMonth = $reviewList->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                $_result = ['month' => $month->format('F')];
                foreach (self::SOURCES as $SOURCE) {
                    $_result['data'][$SOURCE] = round((float)$reviewListByMonth->where('source_name', '=', $SOURCE)->avg('rating'), 2);
                    if (empty($_result['data'][$SOURCE]) && !empty($predData)) {
                        $_result['data'][$SOURCE] = $predData[$SOURCE];
                    }
                }

                $result[] = $_result;
                $predData = $_result['data'];
            }

            return response()->json($result);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param \Google_Client $gClient
     * @param Request $request
     * @return JsonResponse
     */
    public function performance(\Google_Client $gClient, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();
        if ($accessToken->isEmpty()) {
            // need to get access token
            return response()->json(['message'=>'Oauth token required. Please Connect your Google account.'], 403);
        }

        try {
            $locations = $this->getLocationsQueryByRequest($user, $request)
                ->get(['google_account_id', 'raw_data']);

            /** @var OAuth $oauth */
            $oauth = $accessToken->first();
            $oauth->configureGoogle($gClient);

            $gmb = new GoogleMyBusiness($gClient);
            $result = (new LocationsInsightsService())->getPerformance($gmb, $locations);

            return response()->json($result);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function scanResults(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            // query
            $query = $this->getLocationsQueryByRequest($user, $request);

            [$start, $end] = $this->getParsedPeriod($request);
            if ($start instanceof \DateTimeInterface) {
                $locations = $query->with(['latestScanResult' => static function (Relation $query) use ($start, $end) {
                    $query->where('created_at', '>=', $start->format('Y-m-d'));
                    if ($end instanceof \DateTimeInterface) {
                        $query->where('created_at', '<=', $end->format('Y-m-d'));
                    }
                }])->get();
            } else {
                $locations = $query->with(['latestScanResult'])->get();
            }

            return response()->json($locations);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Builder
     */
    private function getLocationsQueryByRequest(User $user, Request $request): Builder
    {
        $status = (string)$request->input('params.status');

        $query = Location::query()->select('locations.*')
            ->where('locations.created_by', $user->id);

        if (is_array($rating = $request->input('params.rating'))) {
            $min = (int)($rating[0] ?? 0);
            $max = (int)($rating[1] ?? 5);
            $reviews = Review::query()
                ->selectRaw('COALESCE(AVG(rating), 0) AS rating_avg')
                ->whereRaw('reviews.location_id = locations.id');
            $query->selectSub($reviews, 'rating_avg')
                ->havingBetween('rating_avg', [$min, $max]);
        }

        switch ($status) {
            case self::LOCATION_STATUS_VERIFIED:
                $query->where('locations.is_confirmed', '=', 1);
                break;
            case self::LOCATION_STATUS_UNVERIFIED:
                $query->where('locations.is_confirmed', '=', 0);
                break;
        }

        return $query;
    }

    /**
     * @param Collection $locations
     * @return array
     */
    private function profileScore(Collection $locations): array
    {
        $locationIds = $locations->pluck('id')->toArray();
        $locationIds[] = 0;

        $reviewList = Review::query()
            ->whereIn('location_id', $locationIds)
            ->get();

        $avgScore = (float)$reviewList->avg('rating');
        $prevAvgScore = (float)$reviewList
            ->where('created_at', '<', Carbon::now()->startOfDay()->subMonth()->format('Y-m-d H:i:s'))
            ->avg('rating');
        $res = [
            'avg_score' => round(100 * $avgScore / 5),
            'total' => $locations->count(),
            'total_dynamics' => getDynamicsByMonths($locations),
            'fixes_needed' => $locations->where('latest_scan_result.score', '<', 100)->count(),
            'fixes_needed_dynamics' => getDynamicsByMonths(
                $locations,
                static function (Collection $locations) {
                    return $locations->where('latest_scan_result.score', '<', 100)->count();
                }
            ),
            'profile_score' => round($avgScore, 1),
            'profile_score_dynamics' => getDynamicsInPercent($avgScore, $prevAvgScore),
        ];

        return $res;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getParsedPeriod(Request $request): array
    {
        $now = CarbonImmutable::now()->startOfDay();
        $start = $end = null;
        switch ($request->input('params.preset')) {
            case self::PERIOD_ONE_MONTH:
                $start = $now->subMonth();
                break;
            case self::PERIOD_THREE_MONTHS:
                $start = $now->subMonths(3);
                break;
            case self::PERIOD_ONE_YEAR:
                $start = $now->subYear();
                break;
            case self::PERIOD_USER_CHOICE:
                if (is_array($period = $request->input('params.period'))) {
                    $start = Carbon::createFromFormat('Y-m-d', $period[0])->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d', $period[1])->endOfDay();
                }
                break;
        }
        return [$start, $end];
    }
}