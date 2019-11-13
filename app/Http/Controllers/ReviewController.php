<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

/**
 * Class ReviewController
 * @package App\Http\Controllers
 */
class ReviewController extends Controller
{
    private const REVIEW_TYPE_ALL = 'all';
    private const REVIEW_TYPE_NEGATIVE = 'negative';
    private const REVIEW_TYPE_POSITIVE = 'positive';
    private const REVIEW_TYPE_OVERDUE = 'overdue';

    private const REVIEW_PERIOD_ONE_MONTH = 'last 30 days';
    private const REVIEW_PERIOD_THREE_MONTHS = 'last 3 month';
    private const REVIEW_PERIOD_ONE_YEAR = 'last year';
    private const REVIEW_PERIOD_USER_CHOICE = 'choose period';

    private const REVIEW_STATUS_UNRESPONDED = 'unresponded';
    private const REVIEW_STATUS_RESPONDED = 'responded';

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $threshold = (float)env('REVIEW_RATING_THRESHOLD', 3.5);
        $overdueTime = (int)env('OVERDUE_REVIEW_TIME', 172800);

        try {
            $per_page = $request->query->getInt('per_page', 10);
            $page = $request->query->getInt('page', 1);
            $sources = ['google'];

            [$scoreMin, $scoreMax] = [0, 5];
            if (is_array($score = $request->query->get('score'))) {
                $scoreMin = (int)($score[0] ?? 0);
                $scoreMax = (int)($score[1] ?? 5);
            }
            $status = null;
            if (is_array($_status = $request->query->get('status')) && count($_status) === 1) {
                $status = $_status[0];
            }

            [$sortField, $sortDirection] = ['id', 'asc'];
            if (!empty($sort = $request->query->get('sort'))) {
                [$sortField, $sortDirection] = explode('|', $sort);
            }

            if (!empty($entity = $request->query->get('entity'))) {
                $locationIds = explode(',', $entity);
            } else {
                $locationIds = $user->ownsLocations()->pluck('id')->toArray();
            }

            // query start
            $reviews = Review::query()->with('location')
                ->whereIn('source_name', $sources)
                ->whereIn('location_id', $locationIds)
                ->whereBetween('rating', [$scoreMin, $scoreMax])
                ->orderBy($sortField, $sortDirection);

            switch ($request->query->get('type')) {
                case self::REVIEW_TYPE_NEGATIVE:
                    $reviews->where('rating', '<=', $threshold);
                    break;
                case self::REVIEW_TYPE_POSITIVE:
                    $reviews->where('rating', '>', $threshold);
                    break;
                case self::REVIEW_TYPE_OVERDUE:
                    $reviews->where('created_at', '<=', Carbon::now()->subSeconds($overdueTime)->format('Y-m-d H:i:s'));
                    break;
            }

            switch ($status) {
                case self::REVIEW_STATUS_RESPONDED:
                    $reviews->where('responded', '=', 1);
                    break;
                case self::REVIEW_STATUS_UNRESPONDED:
                    $reviews->where('responded', '=', 0);
                    break;
            }

            switch ($request->query->get('preset')) {
                case self::REVIEW_PERIOD_ONE_MONTH:
                    $reviews->where('created_at', '>=', Carbon::now()->subMonth()->format('Y-m-d H:i:s'));
                    break;
                case self::REVIEW_PERIOD_THREE_MONTHS:
                    $reviews->where('created_at', '>=', Carbon::now()->subMonths(3)->format('Y-m-d H:i:s'));
                    break;
                case self::REVIEW_PERIOD_ONE_YEAR:
                    $reviews->where('created_at', '>=', Carbon::now()->subYear()->format('Y-m-d H:i:s'));
                    break;
                case self::REVIEW_PERIOD_USER_CHOICE:
                    if (is_array($period = $request->query->get('period'))) {
                        $start = Carbon::createFromFormat('Y-m-d', $period[0])->startOfDay()->format('Y-m-d H:i:s');
                        $end = Carbon::createFromFormat('Y-m-d', $period[1])->endOfDay()->format('Y-m-d H:i:s');
                        $reviews->whereBetween('created_at', [$start, $end]);
                    }
                    break;
            }

            return response()->json($reviews->paginate($per_page, ['*'], 'page', $page));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function counters(): JsonResponse
    {
        $threshold = (float)env('REVIEW_RATING_THRESHOLD', 3.5);
        $overdueTime = (int)env('OVERDUE_REVIEW_TIME', 172800);

        try {
            /** @var User $user */
            $user = auth()->user();
            $locationIds = $user->ownsLocations()->pluck('id')->toArray();
            // query start
            $reviews = Review::query()->whereIn('location_id', $locationIds)->get();

            return response()->json([
                self::REVIEW_TYPE_ALL => $reviews->count(),
                self::REVIEW_TYPE_NEGATIVE => $reviews->where('rating', '<=', $threshold)->count(),
                self::REVIEW_TYPE_POSITIVE => $reviews->where('rating', '>', $threshold)->count(),
                self::REVIEW_TYPE_OVERDUE => $reviews->where('created_at', '<=', Carbon::now()->subSeconds($overdueTime)->format('Y-m-d H:i:s'))->count(),
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
