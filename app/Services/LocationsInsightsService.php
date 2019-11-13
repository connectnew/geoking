<?php

namespace App\Services;

use App\Location;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_BasicMetricsRequest;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_MetricRequest;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_ReportLocationInsightsRequest;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_TimeRange;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;
use DateTimeInterface;
use Exception, RuntimeException;

/**
 * Class LocationsInsightsService
 * @package App\Services
 */
class LocationsInsightsService
{

    public const GROUP_METRIC_VIEWS = 'views';
    public const METRIC_VIEWS_MAPS = 'VIEWS_MAPS';
    public const METRIC_VIEWS_SEARCH = 'VIEWS_SEARCH';

    public const GROUP_METRIC_SEARCHES = 'searches';
    public const METRIC_QUERIES_DIRECT = 'QUERIES_DIRECT';
    public const METRIC_QUERIES_INDIRECT = 'QUERIES_INDIRECT';

    public const GROUP_METRIC_ACTIVITY = 'activity';
    public const METRIC_ACTIONS_WEBSITE = 'ACTIONS_WEBSITE';
    public const METRIC_ACTIONS_PHONE = 'ACTIONS_PHONE';
    public const METRIC_ACTIONS_DRIVING_DIRECTIONS = 'ACTIONS_DRIVING_DIRECTIONS';
    public const METRIC_PHOTOS_VIEWS_MERCHANT = 'PHOTOS_VIEWS_MERCHANT';

    /**
     * @param GoogleMyBusiness $googleMyBusiness
     * @param Collection|Location[] $locations
     * @param DateTimeInterface|null $start
     * @param DateTimeInterface|null $end
     * @return array
     */
    public function getPerformance(GoogleMyBusiness $googleMyBusiness, Collection $locations, ?DateTimeInterface $start = null, ?DateTimeInterface $end = null): array
    {
        $now = CarbonImmutable::now();
        if ($start === null) {
            $start = $now->subDays(28)->startOfDay();
        }
        $start2 = $start->subDays(28)->startOfDay();
        if ($end === null) {
            $end = $now->endOfDay();
        }
        $end2 = $end->subDays(28)->endOfDay();

        $mainMetrics = [
            self::METRIC_VIEWS_MAPS, self::METRIC_VIEWS_SEARCH,
            self::METRIC_QUERIES_DIRECT, self::METRIC_QUERIES_INDIRECT,
            self::METRIC_ACTIONS_WEBSITE, self::METRIC_ACTIONS_PHONE,
            self::METRIC_ACTIONS_DRIVING_DIRECTIONS, self::METRIC_PHOTOS_VIEWS_MERCHANT,
        ];
        $groups = [self::GROUP_METRIC_VIEWS, self::GROUP_METRIC_SEARCHES, self::GROUP_METRIC_ACTIVITY];

        try {
            $collection = $locations->groupBy('google_account_id');
            $insightsRequest = new Google_Service_MyBusiness_ReportLocationInsightsRequest();
            $basicMetricsRequest = new Google_Service_MyBusiness_BasicMetricsRequest();
            $metrics = [];
            foreach ($mainMetrics as $metric) {
                $metrics[] = new Google_Service_MyBusiness_MetricRequest(['metric' => $metric, 'options' => ['AGGREGATED_TOTAL']]);
            }
            $basicMetricsRequest->setMetricRequests($metrics);
            $basicMetricsRequest->setTimeRange(
                new Google_Service_MyBusiness_TimeRange(['startTime' => $start->toIso8601ZuluString(),'endTime' => $end->toIso8601ZuluString()])
            );
            $insightsRequest->setBasicRequest($basicMetricsRequest);
            // first
            $result = [];
            /** @var Collection $_locations */
            foreach ($collection as $account => $_locations) {
                $insightsRequest->setLocationNames($_locations->pluck('raw_data.name')->toArray());
                $list = $googleMyBusiness->accounts_locations->reportInsights($account, $insightsRequest)->getLocationMetrics() ?? [];

                foreach ($list as $item) {
                    $result[$item['locationName']] = $item['metricValues'];
                }
            }
            // last
            $basicMetricsRequest->setTimeRange(
                new Google_Service_MyBusiness_TimeRange(['startTime' => $start2->toIso8601ZuluString(),'endTime' => $end2->toIso8601ZuluString()])
            );
            $result2 = [];
            /** @var Collection $_locations */
            foreach ($collection as $account => $_locations) {
                $insightsRequest->setLocationNames($_locations->pluck('raw_data.name')->toArray());
                $list = $googleMyBusiness->accounts_locations->reportInsights($account, $insightsRequest)->getLocationMetrics() ?? [];

                foreach ($list as $item) {
                    $result2[$item['locationName']] = $item['metricValues'];
                }
            }

            $performance = $this->preparePerformance($result);
            $performance2 = $this->preparePerformance($result2);

            foreach ($mainMetrics as $metric) {
                foreach ($groups as $group) {
                    if (array_key_exists($metric, $performance[$group])) {
                        $performance[$group][$metric.'_dynamics'] = getDynamicsInPercent($performance[$group][$metric], $performance2[$group][$metric]);
                    }
                }
            }

            return $performance;
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param array $list
     * @return array
     */
    private function preparePerformance(array $list): array
    {
        $performance = [
            self::GROUP_METRIC_VIEWS => [
                self::METRIC_VIEWS_MAPS => 0,
                self::METRIC_VIEWS_SEARCH => 0,
                'total' => 0
            ],
            self::GROUP_METRIC_SEARCHES => [
                self::METRIC_QUERIES_DIRECT => 0,
                self::METRIC_QUERIES_INDIRECT => 0,
                'total' => 0
            ],
            self::GROUP_METRIC_ACTIVITY => [
                self::METRIC_ACTIONS_WEBSITE => 0,
                self::METRIC_ACTIONS_PHONE => 0,
                self::METRIC_ACTIONS_DRIVING_DIRECTIONS => 0,
                self::METRIC_PHOTOS_VIEWS_MERCHANT => 0,
                'total' => 0
            ],
        ];

        foreach ($list as $metricValues) {
            foreach ($metricValues as ['metric' => $metric, 'totalValue' => $totalValue]) {
                if (array_key_exists($metric, $performance[self::GROUP_METRIC_VIEWS])) {
                    $performance[self::GROUP_METRIC_VIEWS][$metric] += (int)$totalValue['value'];
                    $performance[self::GROUP_METRIC_VIEWS]['total'] += (int)$totalValue['value'];
                }
                if (array_key_exists($metric, $performance[self::GROUP_METRIC_SEARCHES])) {
                    $performance[self::GROUP_METRIC_SEARCHES][$metric] += (int)$totalValue['value'];
                    $performance[self::GROUP_METRIC_SEARCHES]['total'] += (int)$totalValue['value'];
                }
                if (array_key_exists($metric, $performance[self::GROUP_METRIC_ACTIVITY])) {
                    $performance[self::GROUP_METRIC_ACTIVITY][$metric] += (int)$totalValue['value'];
                    $performance[self::GROUP_METRIC_ACTIVITY]['total'] += (int)$totalValue['value'];
                }
            }
        }

        return $performance;
    }
}