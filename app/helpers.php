<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

if (! function_exists('sessionId')) {

    function sessionId()
    {
        $session_id = Carbon::now()->timestamp;
        $session_id = mb_strimwidth(Hash::make($session_id),3,50);
        return $session_id;
        
    }
}

if (!function_exists('getDynamicsByMonths')) {
    /**
     * @param Collection $collection
     * @param callable $calc
     * @param string $dateTimeFiled
     * @return float
     */
    function getDynamicsByMonths(Collection $collection, ?callable $calc = null,  string $dateTimeFiled = 'created_at'): ?float
    {
        $now = CarbonImmutable::now();
        /** @var CarbonImmutable $start1 */
        $start1 = $now->startOfDay()->subMonth();
        /** @var CarbonImmutable $end1 */
        $end1 = $now->endOfDay();
        /** @var CarbonImmutable $start2 */
        $start2 = $start1->subMonth();
        /** @var CarbonImmutable $end2 */
        $end2 = $end1->subMonth();

        if (null === $calc) {
            $calc = static function (Collection $collection) { return $collection->count(); };
        }

        $resNow = (float)$calc($collection->whereBetween($dateTimeFiled, [$start1->format('Y-m-d H:i:s'), $end1->format('Y-m-d H:i:s')]));
        $resPrev = (float)$calc($collection->whereBetween($dateTimeFiled, [$start2->format('Y-m-d H:i:s'), $end2->format('Y-m-d H:i:s')]));

        if ($resNow <= 0 || $resPrev <= 0) {
            return null;
        }

        return getDynamicsInPercent($resNow, $resPrev);
    }
}

if (!function_exists('getDynamicsInPercent')) {
    /**
     * @param float $newValue
     * @param float $prevValue
     * @param int $precision
     * @return float|null
     */
    function getDynamicsInPercent(?float $newValue, ?float $prevValue, int $precision=1): ?float
    {
        $newValue = (float)$newValue;
        $prevValue = (float)$prevValue;

        if ($prevValue <= 0) {
            return null;
        }
        return round(100 * (($newValue - $prevValue)/$prevValue), $precision);
    }
}