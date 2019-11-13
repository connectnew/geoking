<?php

namespace App\Http\Controllers;

use App\Jobs\SyncUserListing;
use App\OAuth;
use App\Review;
use App\ReviewReply;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Google_Client;
use Exception;
use Scottybo\LaravelGoogleMyBusiness\Google_Service_MyBusiness_ReviewReply;
use Scottybo\LaravelGoogleMyBusiness\GoogleMyBusiness;

/**
 * Class ReviewReplyController
 * @package App\Http\Controllers
 */
class ReviewReplyController extends Controller
{
    /**
     * @param Google_Client $gClient
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Google_Client $gClient, Request $request): JsonResponse
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            $accounts = $user->accounts()->get();
            if ($accounts->isEmpty()) {
                return response()->json(['error' => 'Account required. Please added new account.'], 403);
            }
            $review = Review::find($request->json('review_id'));
            if (!($review instanceof Review)) {
                return response()->json(['error' => 'Review not found.'], 404);
            }

            /** @var OAuth $oauth */
            $oauth = $user->oauth()->where('provider', OAuth::GOOGLE)->get()->first();
            $oauth->configureGoogle($gClient);
            $gmb = new GoogleMyBusiness($gClient);

            $reply = new Google_Service_MyBusiness_ReviewReply();
            $reply->setComment($request->json('reply'));

            $gmb->accounts_locations_reviews->updateReply($review->source_key, $reply);

            /** @var ReviewReply $reviewReply */
            $reviewReply = $review->reviewReply()->first() ?? new ReviewReply();
            $reviewReply->review_id = $review->id;
            $reviewReply->comment = $reply->getComment();
            $reviewReply->save();

            // update review
            $review->responded = true;
            $review->save();

            return response()->json($reviewReply);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
