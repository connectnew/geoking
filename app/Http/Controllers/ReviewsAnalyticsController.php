<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ReviewAnalyticsController
 * @package App\Http
 */
class ReviewsAnalyticsController extends Controller
{
    private const LAST_MONTHS_COUNT = 12;
    private const REVIEW_STATUS_UNRESPONDED = 'Unresponded';
    private const REVIEW_STATUS_RESPONDED = 'Responded';

    private const SOURCES = ['google', 'bing', 'fb', 'force'];

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function statistics(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $result = [];

        $threshold = (float)env('REVIEW_RATING_THRESHOLD', 3.5);
        try {
            // query
            $reviews = $this->getReviewsQueryByRequest($user, $request)
                ->get();

            // total
            $result['total'] = $this->getTotal($reviews, $threshold);
            // for the last months
            $result['last_months'] = $this->getForLastMonths($reviews, $threshold, self::LAST_MONTHS_COUNT);
            // scores
            $result['scores'] = $this->getScores($reviews);

            return response()->json($result);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function customerSatisfaction(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $threshold = (float)env('REVIEW_RATING_THRESHOLD', 3.5);

        try {
            // query start
            $perTime = $this->getReviewsQueryByRequest($user, $request)
                ->where('rating', '>', $threshold)
                ->get()
                ->groupBy(static function (Review $review) {
                    return $review->created_at->format('gA');
                })
                ->map(static function (Collection $collection, $key) {
                    return [
                        'label' => $key,
                        'key' => $collection->first()->created_at->format('g A'),
                        'value' => $collection->count()
                    ];
                });

            return response()->json([
                'per_time_of_day' => $perTime,
                'peak_time' => $perTime->sortByDesc('value')->first()['key'] ?? ''
            ]);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function medianResponseTime(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $now = CarbonImmutable::now();
        /** @var CarbonImmutable $start1 */
        $start1 = $now->startOfDay()->subMonth();
        /** @var CarbonImmutable $end1 */
        $end1 = $now->endOfDay();
        /** @var CarbonImmutable $start2 */
        $start2 = $start1->subMonth();
        /** @var CarbonImmutable $end2 */
        $end2 = $end1->subMonth();

        $syntax = [
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
            'join' => ' ',
            'options' => Carbon::SEQUENTIAL_PARTS_ONLY
        ];

        try {
            $now = CarbonImmutable::now();
            // query start
            $reviews = $this->getReviewsQueryByRequest($user, $request)->with('reviewReply')->get();
            $reviews1 = $reviews->whereBetween('created_at', [$start1->format('Y-m-d H:i:s'), $end1->format('Y-m-d H:i:s')]);
            $reviews2 = $reviews->whereBetween('created_at', [$start2->format('Y-m-d H:i:s'), $end2->format('Y-m-d H:i:s')]);

            $medianResponseTime1 = $reviews1
                ->map(static function(Review $review) use ($now) {
                    return ['time_to_response' => $review->created_at->diffInSeconds($review->reviewReply->created_at ?? $now)];
                })
                ->median('time_to_response');

            $medianResponseTime2 = $reviews2
                ->map(static function(Review $review) use ($now) {
                    return ['time_to_response' => $review->created_at->diffInSeconds($review->reviewReply->created_at ?? $now)];
                })
                ->median('time_to_response');

            $dynamics = getDynamicsInPercent($medianResponseTime1, $medianResponseTime2, 0);

            return response()->json([
                'median_response_time' => CarbonInterval::seconds((int)$medianResponseTime1)->cascade()->forHumans($syntax, false, 2),
                'median_response_time_dynamics' => $dynamics
            ]);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function locationAnalysis(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        try {
            // query start
            $reviews = $this->getReviewsQueryByRequest($user, $request)->get();

            $newReviewTime = Carbon::now()->subMonth()->startOfDay()->format('Y-m-d H:i:s');

            $stat = $this->getStatBySources($reviews, $newReviewTime);
            $sources = [];
            foreach (self::SOURCES as $source) {
                $sources[$source] = array_key_exists($source, $stat) ? $stat[$source] : ['source_name' => $source];
            }
            $result = [
                'sources' => $sources,
                'review_sites' => $reviews->unique('location_id')->count()
            ];

            return response()->json($result);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Builder
     */
    private function getReviewsQueryByRequest(User $user, Request $request): Builder
    {
        $locationId = (int)$request->input('params.location');
        $rating = (int)$request->input('params.rating');
        $source = (string)$request->input('params.source');
        $status = (string)$request->input('params.status');

        $locationIds[] = $locationId;
        if ($locationId <= 0) {
            $locationIds = $user->ownsLocations()->pluck('id')->toArray();
        }

        $query = Review::query()
            ->whereIn('location_id', $locationIds);

        if ($rating > 0) {
            $query->where('rating', $rating);
        }

        if (!empty($source)) {
            $query->where('source_name', $source);
        }

        switch ($status) {
            case self::REVIEW_STATUS_RESPONDED:
                $query->where('responded', '=', 1);
                break;
            case self::REVIEW_STATUS_UNRESPONDED:
                $query->where('responded', '=', 0);
                break;
        }

        return $query;
    }

    /**
     * @param Collection $reviews
     * @param float $threshold
     * @return array
     */
    private function getTotal(Collection $reviews, float $threshold): array
    {
        $positive = $reviews->where('rating', '>', $threshold);
        $negative = $reviews->where('rating', '<=', $threshold);
        $pending_response = $reviews->where('responded', '<>', 1);
        return [
            'average_score' => round($reviews->average('rating'), 1),
            'average_score_dynamics' => $this->getDynamics(
                $reviews,
                static function (Collection $reviews) {
                    return round($reviews->average('rating'), 1);
                }
            ),
            'positive' => $positive->count(),
            'positive_dynamics' => $this->getDynamics($positive),
            'negative' => $negative->count(),
            'negative_dynamics' => $this->getDynamics($negative),
            'pending_response' => $pending_response->count(),
            'pending_response_dynamics' => $this->getDynamics($pending_response),
        ];
    }

    /**
     * @param Collection $reviews
     * @param float $threshold
     * @param int $monthsCount
     * @return array
     */
    private function getForLastMonths(Collection $reviews, float $threshold, int $monthsCount): array
    {
        $result = [];
        $now = CarbonImmutable::now();
        $negativeReviews = $reviews->where('rating', '<=', $threshold);
        $positiveReviews = $reviews->where('rating', '>', $threshold);
        // per month
        for ($i=0; $i<$monthsCount; $i++) {
            /** @var CarbonImmutable $month */
            $month = $now->subMonthsWithoutOverflow($monthsCount-$i-1);
            $startOfMonth = $month->startOfMonth()->format('Y-m-d H:i:s');
            $endOfMonth = $month->endOfMonth()->format('Y-m-d H:i:s');
            $result[] = [
                'month' => $month->format('M'),
                'positive' => $positiveReviews->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                'negative' => $negativeReviews->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            ];
        }

        return $result;
    }

    /**
     * @param Collection $reviews
     * @return array
     */
    private function getScores(Collection $reviews): array
    {
        $result = [];
        $count = $reviews->count();
        for ($score = 1; $score <= 5; $score++) {
            $total = $reviews->where('rating', '=', $score)->count();
            $result[] = [
                'score' => $score,
                'total' => $total,
                'percent' => $count > 0 ? round(100 * $total/$count, 2) : .0,
            ];
        }
        return $result;
    }

    /**
     * @param Collection $reviews
     * @param string $newReviewTime
     * @return array
     */
    private function getStatBySources(Collection $reviews, string $newReviewTime): array
    {
        $self = $this;
        return $reviews
            ->groupBy('source_name')
            ->map(static function (Collection $groupedReviews) use ($self, $newReviewTime) {
                /** @var Review $lastReview */
                $lastReview = $groupedReviews->sortByDesc('created_at')->first();
                $newReviews = $groupedReviews->where('created_at', '>', $newReviewTime);
                return [
                    'source_name' => $lastReview->source_name,
                    'total_review' => $groupedReviews->count(),
                    'total_review_dynamics' => $self->getDynamics($groupedReviews),
                    'overall_rating' => round($groupedReviews->average('rating'), 1),
                    'overall_rating_dynamics' => $self->getDynamics(
                        $groupedReviews,
                        static function (Collection $reviews) {
                            return round($reviews->average('rating'), 1);
                        }
                    ),
                    'new_reviews' => $newReviews->count(),
                    'last_added' => $lastReview ? $lastReview->created_at->diffForHumans() : null
                ];
            })
            ->all();
    }

    /**
     * @param Collection $reviews
     * @param callable $calc
     * @return float
     */
    private function getDynamics(Collection $reviews, ?callable $calc = null): ?float
    {
        return round(getDynamicsByMonths($reviews, $calc));
    }
}