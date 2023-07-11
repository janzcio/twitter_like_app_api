<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Services\TweetService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUpdateTweetRequest;

class TweetController extends Controller
{
    protected  $tweetService;

    /**
     * @param TweetService $tweetService
     */
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    /**
     * Create a new Tweet
     *
     * @param StoreUpdateTweetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(StoreUpdateTweetRequest $request)
    {
        // Create a new tweet
        $tweet = $this->tweetService->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
            'attachment' => $request->file('attachment') ? $request->file('attachment')->store('attachments') : null,
        ]);

        return $this->generateSuccessCreated(['message' => 'Tweet created successfully']);
    }

    /**
     * Update tweet
     *
     * @param StoreUpdateTweetRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTweetRequest $request, $id)
    {
        // Find the tweet
        $tweet = $this->tweetService->find($id);

        // not found
        if (!$tweet) {
            return $this->generateNotFoundResponse();
        }

        // Check if the authenticated user is the owner of the tweet
        if ($tweet->user_id !== $request->user()->id) {
            return $this->generateUnauthorizedResponse();
        }

        // Update the tweet
        $this->tweetService->update($tweet, [
            'content' => $request->content,
            'attachment' => $request->file('attachment') ? $request->file('attachment')->store('attachments') : $tweet->attachment,
        ]);

        return $this->generateSuccess(['message' => 'Tweet updated successfully']);
    }

    /**
     * delete a tweet
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        // Find the tweet
        $tweet = $this->tweetService->find($id);

        // not found
        if (!$tweet) {
            return $this->generateNotFoundResponse();
        }

        // check if authorized
        if ($tweet && ($tweet->user_id !== Auth::user()->id)) {
            return $this->generateUnauthorizedResponse();
        }

        // Delete the tweet
        $this->tweetService->delete($id);

        return $this->generateSuccess(['message' => 'Tweet deleted successfully']);
    }

    /**
     * Get the followed tweet
     *
     * @param Request $request
     * @return void
     */
    public function getFollowedTweets(Request $request)
    {
        $tweets = $request->user()->followedUsers()->with('tweets')->get();

        return $this->generateSuccess($tweets);
    }
}
