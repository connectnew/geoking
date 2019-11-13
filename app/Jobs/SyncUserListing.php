<?php

namespace App\Jobs;

use App\OAuth;
use App\Review;
use App\ReviewReply;
use App\User;
use App\Location;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Review;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_Reviewer;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_ReviewReply;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;

/**
 * Class SyncUserListing
 * @package App\Jobs
 */
class SyncUserListing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $tries = 1;

    private $updatedLocationIds = [0];
    private $updatedReviewIds = [0];
    private $updatedReviewReplyIds = [0];

    /**
     * Create a new job instance.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @param Google_Client $client
     * @return void
     */
    public function handle(Google_Client $client): void
    {
        Auth::loginUsingId($this->userId);
        /** @var User $user */
        $user = Auth::user();

        // load current locations, reviews & review replies
        $locations = $user->ownsLocations();
        $lIds = array_merge($locations->get()->pluck('id')->toArray(), [0]); // array not empty
        $reviews = Review::query()->whereIn('location_id', $lIds);
        $rIds = array_merge($reviews->get()->pluck('id')->toArray(), [0]); // array not empty
        $reviewReplies = ReviewReply::query()->whereIn('review_id', $rIds);

        $accessToken = $user->oauth()->where('provider', OAuth::GOOGLE)->get();
        $oauth = $accessToken->first();
        $oauth->configureGoogle($client);
        $gmb = new GoogleMyBusiness($client);
        $accounts = $gmb->accounts->listAccounts()->toSimpleObject();
        foreach ($accounts->accounts as $account) {
            $this->syncLocations($account['name'], $gmb);
        }
        //Auth::logout();

        // delete locations, reviews & review replies
        $locations->whereNotIn('id', $this->updatedLocationIds)->delete();
        $reviews->whereNotIn('id', $this->updatedReviewIds)->delete();
        $reviewReplies->whereNotIn('id', $this->updatedReviewReplyIds)->delete();
    }

    /**
     * @param string $parent
     * @param GoogleMyBusiness $gmb
     */
    private function syncLocations(string $parent, GoogleMyBusiness $gmb): void
    {
        $parameters = [];
        do {
            $response = $gmb->accounts_locations->listAccountsLocations($parent);
            $locations = $response->getLocations() ?? [];
            $parameters['pageToken'] = $response->getNextPageToken();

            foreach ($locations as $location) {
                $locationGoogleId = str_replace($parent, '', $location['name']);
                /** @var Location $locationLocal */
                $locationLocal = Location::query()
                    ->where('created_by', '=', $this->userId)
                    ->where('raw_data->name', 'like', '%' . $locationGoogleId)
                    ->first() ?? new Location(['created_by' => $this->userId]);

                $locationLocal->title = $location['locationName'];
                $locationLocal->google_account_id = $parent;
                $locationLocal->phone = $location['primaryPhone'] ?? "";
                $locationLocal->website = $location['websiteUrl'] ?? "";
                $locationLocal->country = $location['address']['regionCode'] ?? "CA";
                $locationLocal->address = $location['address']['addressLines'][1] ?? "";
                $locationLocal->street = $location['address']['addressLines'][0] ?? "";
                $locationLocal->city = $location['address']['locality'] ?? "";
                $locationLocal->state = $location['address']['administrativeArea'] ?? "";
                $locationLocal->zip = $location['address']['postalCode'] ?? "";
                $locationLocal->latitude = $location['latlng']['latitude'] ?? 0;
                $locationLocal->longitude = $location['latlng']['longitude'] ?? 0;
                $locationLocal->raw_data = $location;
                $locationLocal->is_confirmed = (bool)($location['locationState']['isVerified'] ?? false);
                $save = $locationLocal->save();

                // location id
                $this->updatedLocationIds[] = $locationLocal->id;

                if ($save) {
                    try {
                        $this->syncReviews($location['name'], $locationLocal, $gmb);
                    } catch (\Google_Service_Exception $exception) {
                        // Requested review was not found.
                        continue;
                    }
                }
            }
        } while ($parameters['pageToken'] !== null);
    }

    /**
     * @param string $parent
     * @param Location $location
     * @param GoogleMyBusiness $gmb
     */
    private function syncReviews(string $parent, Location $location, GoogleMyBusiness $gmb): void
    {
        $parameters = [];
        do {
            $response = $gmb->accounts_locations_reviews->listAccountsLocationsReviews($parent, $parameters);
            $parameters['pageToken'] = $response->getNextPageToken();

            $this->saveReviews($location, $response->getReviews() ?? []);

        } while ($parameters['pageToken'] !== null);
    }

    /**
     * @param Location $location
     * @param Google_Service_MyBusiness_Review[] $reviews
     */
    private function saveReviews(Location $location, array $reviews): void
    {
        $attributes = [
            'location_id' => $location->id,
            'source_name' => 'google',
            'source_key' => ''
        ];
        foreach ($reviews as $review) {
            $review = new Google_Service_MyBusiness_Review($review);
            $attributes['source_key'] = $review->getName();
            /** @var Google_Service_MyBusiness_Reviewer $reviewer */
            $reviewer = new Google_Service_MyBusiness_Reviewer($review->getReviewer());
            /** @var Google_Service_MyBusiness_ReviewReply $reviewReply */
            $reviewReply = $review->getReviewReply() ? new Google_Service_MyBusiness_ReviewReply($review->getReviewReply()) : null;
            // update or create review
            $localReview = Review::updateOrCreate($attributes, [
                'reviewer_is_anonymous' => $reviewer->getIsAnonymous(),
                'reviewer_name' => $reviewer->getDisplayName(),
                'reviewer_photo_url' => $reviewer->getProfilePhotoUrl(),
                'rating' => self::getRating($review->getStarRating()),
                'comment' => self::clearTextFromGoogleTranslate($review->getComment()),
                'responded' => $reviewReply instanceof Google_Service_MyBusiness_ReviewReply,
                'created_at' => self::createFromZuluFormat($review->getCreateTime()),
                'updated_at' => self::createFromZuluFormat($review->getUpdateTime())
            ]);
            // review id
            $this->updatedReviewIds[] = $localReview->id;

            // update or create review reply
            if ($reviewReply instanceof Google_Service_MyBusiness_ReviewReply) {
                $localReviewReply = ReviewReply::firstOrNew(['review_id' => $localReview->id], [
                    'created_at' => self::createFromZuluFormat($reviewReply->getUpdateTime()),
                    'created_by' => $this->userId
                ]);

                $localReviewReply->comment = self::clearTextFromGoogleTranslate($reviewReply->getComment());
                $localReviewReply->updated_at = self::createFromZuluFormat($reviewReply->getUpdateTime());
                $localReviewReply->updated_by = $this->userId;
                $localReviewReply->save();

                // review reply id
                $this->updatedReviewReplyIds[] = $localReviewReply->id;

            }
        }
    }

    /**
     * @param string $text
     * @return string
     */
    private static function clearTextFromGoogleTranslate(?string $text): ?string
    {
        $pattern1 = '/^\(Translated by Google\).*?\(Original\)/us';
        $pattern2 = '/\n\n\(Translated by Google\)\n.+$/us';
        return !empty($text) ? trim(preg_replace([$pattern1, $pattern2], '', $text)) : null;
    }

    /**
     * @param string $starRating
     * @return int
     */
    private static function getRating(string $starRating): ?int
    {
        switch ($starRating) {
            case 'STAR_RATING_UNSPECIFIED':
                return null;
            case 'ONE':
                return 1;
            case 'TWO':
                return 2;
            case 'THREE':
                return 3;
            case 'FOUR':
                return 4;
            case 'FIVE':
                return 5;
            default:
                throw new \OutOfBoundsException('StarRating');
        }
    }

    /**
     * @param string $dateTime
     * @return string
     */
    private static function createFromZuluFormat(string $dateTime): string
    {
        $dateTime = preg_replace('/\.\d+Z/', 'Z', $dateTime);
        return Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $dateTime, new \DateTimeZone('UTC'))->format('Y-m-d H:i:s');
    }
}
