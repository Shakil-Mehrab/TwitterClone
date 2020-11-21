<?php

namespace App\Http\Resources;

use App\Http\Resources\TweetResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TweetCollection extends ResourceCollection
{
    public $collects=TweetResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=>$this->collection
        ];
    }
    public function with($request)
    {
        return [
            'meta' => [
                'likes' => $this->likes($request),
                'retweets' => $this->retweets($request),
            ]
        ];
    }
    protected function likes($request)
    {
        if (!$user = $request->user()) {//sign or no bujhay.$user just an assign for next use
            return [];
        }
        // ->merge($this->collection->pluck('original_tweet_id'))
        return $user->likes()
            ->whereIn(
                'tweet_id',
                $this->collection->pluck('id')->merge($this->collection->pluck('original_tweet_id'))////eta na korle jotokhon original id v-observe
                // hoy totokhon like ba retweet  red or green thke.tai original id all time show korte hoy
            )
            ->pluck('tweet_id')//match korle oi tweet id ta pluck koro
            ->toArray();
    }

    protected function retweets($request)
    {
        if (!$user = $request->user()) {
            return [];
        }

        return $user->retweets()
            ->whereIn(
                'original_tweet_id',
                $this->collection->pluck('id')->merge($this->collection->pluck('original_tweet_id'))
            )
            ->pluck('original_tweet_id')
            ->toArray();
    }
}
