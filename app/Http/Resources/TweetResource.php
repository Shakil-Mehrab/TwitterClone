<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Http\Resources\MediaCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'body'=>$this->body,
            'type'=>$this->type,
            'parent_id'=>$this->parent_id,
            'parent_ids'=>$this->parents()->pluck('id')->toArray(),
            'original_tweet'=>new TweetResource($this->originalTweet),
            "likes_count"=>$this->likes->count(),
            "retweets_count"=>$this->retweets->count(),
            'user'=>new UserResource($this->user),
            'media'=>new MediaCollection($this->media),//media TweetMedia ja only tweet_id,media_id bohon kore
            'entities'=>new EntityCollection($this->entities),
            "replies_count"=>$this->replies->count(),
            "replying_to"=>optional(optional($this->parentTweet)->user)->username,
            'created_at'=>$this->created_at->timestamp
        ];
    }
}
