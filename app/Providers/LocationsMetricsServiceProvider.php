<?php

namespace App\Providers;

use App\Services\LocationsInsightsService;
use Illuminate\Support\ServiceProvider;

/**
 * Class LocationsMetricsServiceProvider
 * @package App\Providers
 */
class LocationsMetricsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // do nothing
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(LocationsInsightsService::class, static function () {
            return new LocationsInsightsService();
        });
    }
}