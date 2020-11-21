<?php

namespace App\Events\Tweets;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TweetLikesWereUpdated implements ShouldBroadcast
{
    //ShouldBroadcast na dile default private chanel dekhay
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;

    protected $tweet;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Tweet $tweet)
    {
        $this->user = $user;
        $this->tweet = $tweet;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function broadcastWith()
    {
        //ki ki niye broad cast hode tai dekhay
        return [
            'id' => $this->tweet->id,
            'user_id' => $this->user->id,
            'count' => $this->tweet->likes->count(),
        ];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function broadcastAs()//eta public.cz tweet public hoy
    {
        return 'TweetLikesWereUpdated';//ai event ti websocket a paoa jabe.na dile puro namespace soho okhane dekahay
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('tweets');
    }
}
