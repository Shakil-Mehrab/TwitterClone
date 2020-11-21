<?php

namespace App\Http\Controllers\Api\Tweets;

use App\Models\Tweet;
use App\Tweets\TweetType;
use App\Models\TweetMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Tweets\TweetWasCreated;
use App\Http\Resources\TweetCollection;
use App\Notifications\Tweets\TweetMentionedIn;
use App\Http\Requests\Tweets\TweetStoreRequest;
use App\Http\Resources\TweetResource;

class TweetController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['store']);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $tweets = Tweet::with([
            'user',
            'likes',
            'retweets',
            'replies',
            'media.baseMedia',
            'originalTweet.user',
            'originalTweet.likes',
            'originalTweet.retweets',
            'originalTweet.media.baseMedia',
        ])
            ->find(explode(',', $request->ids));

        return new TweetCollection($tweets);
    }
    public function show(Tweet $tweet){
        return new TweetCollection(collect([$tweet])->merge($tweet->parents()));
    }

    /**
     * Undocumented function
     *
     * @param TweetStoreRequest $request
     * @return void
     */
    public function store(TweetStoreRequest $request)
    {
        $tweet = $request->user()->tweets()->create(array_merge($request->only('body'), [
            'type' => TweetType::TWEET
        ]));

        foreach($request->media as $id) {
            $tweet->media()->save(TweetMedia::find($id));//ekha media for tweetMedia::class
        }

        foreach ($tweet->mentions->users() as $user) {
            if ($request->user()->id !== $user->id) {
                $user->notify(new TweetMentionedIn($request->user(), $tweet));
            }
        }
        // $tweet->mentions->users()->each->notify(new TweetMentionedIn($request->user(), $tweet));//evabe dileo hoy
        broadcast(new TweetWasCreated($tweet));
    }
}
