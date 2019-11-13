<?php

namespace App\Providers;

use App\Services\ScanService;
use Illuminate\Support\ServiceProvider;

/**
 * Class ScanServiceProvider
 * @package App\Providers
 */
class ScanServiceProvider extends ServiceProvider
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
        $this->app->singleton(ScanService::class, static function () {
            return new ScanService();
        });
    }
}