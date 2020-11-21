<?php

namespace App\Http\Controllers\Api\Media;

use App\Models\TweetMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TweetMediaCollection;
use App\Http\Requests\Media\MediaStoreRequest;

class MediaController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth:sanctum']);
    }

    public function store(MediaStoreRequest $request)
    {
        $result = collect($request->media)->map(function ($media) {
            return $this->addMedia($media);
        });

        return new TweetMediaCollection($result);
    }

    protected function addMedia($media)
    {
        $tweetMedia = TweetMedia::create([]);//sob field null.tachara media id jana nei,so next
        $tweetMedia->baseMedia()
            ->associate($tweetMedia->addMedia($media)->toMediaCollection())
            //associate laravel theke asche.er dara j media ai matro make holo ta data tweetMedia abar update hobe
            //addMedia($media),toMediaCollection()) package function
            ->save();

        return $tweetMedia;
    }
}
