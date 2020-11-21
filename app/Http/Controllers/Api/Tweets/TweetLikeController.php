<?php

namespace App\Http\Controllers\Api\Tweets;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Tweets\TweetLiked;
use App\Events\Tweets\TweetLikesWereUpdated;

class TweetLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Undocumented function
     *
     * @param Tweet $tweet
     * @param Request $request
     * @return void
     */
    public function store(Tweet $tweet, Request $request)
    {
        if ($request->user()->hasLiked($tweet)) {//refresh er age double click korle 2 like hoye jay.ai problem arate eta/
            return response(null, 409);//409 alread exist,500 controller,400 route not find,404 not found
        }
        $request->user()->likes()->create([
            'tweet_id' => $tweet->id
        ]);
        // if ($request->user()->id !== $tweet->user_id) {
            $tweet->user->notify(new TweetLiked($request->user(), $tweet));
        // }

        broadcast(new TweetLikesWereUpdated($request->user(), $tweet));
    }

    /**
     * Undocumented function
     *
     * @param Tweet $tweet
     * @param Request $request
     * @return void
     */
    public function destroy(Tweet $tweet, Request $request)
    {
        $request->user()->likes->where('tweet_id', $tweet->id)->first()->delete();

        broadcast(new TweetLikesWereUpdated($request->user(), $tweet));
    }
}
