<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Google_Client::class, function ($app) {
            $client = new Google_Client();
            $client->setApplicationName(config('google.application_name'));
            $client->setClientId(config('google.client_id'));
            $client->setClientSecret(config('google.client_secret'));

            // Incremental authorization
            $client->setIncludeGrantedScopes(true);

            // Turn on more informative error messages
            $client->setApiFormatV2(true);

            // Allow access to Google API when the user is not present.
            $client->setAccessType(config('google.access_type'));
            $client->setRedirectUri(config('google.redirect_uri'));
            $client->setScopes(config('google.scopes'));
            $client->setApprovalPrompt(config('google.approval_prompt'));
            $client->setPrompt(config('google.prompt'));

            return $client;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
