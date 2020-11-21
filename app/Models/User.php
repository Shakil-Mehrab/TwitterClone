<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Tweet;
use App\Models\Follower;
use App\Tweets\TweetType;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // HasApiTokens
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function avatar(){
        return 'https://www.gravatar.com/avatar/'.md5($this->email).'?d=mp';
    }
    public function hasLiked(Tweet $tweet)
    {
        return $this->likes->contains('tweet_id', $tweet->id);//ache kina
    }
    public function tweets(){
        return $this->hasMany(Tweet::class);
    }
    public function following(){
        return $this->belongsToMany(User::class,'followers','user_id','following_id');
    }
    public function followers(){
        return $this->belongsToMany(User::class,'followers','following_id','user_id');
    }
    public function tweetsFromFollowing(){
        return $this->hasManyThrough(
            Tweet::class,Follower::class,'user_id','user_id','id','following_id' //tweet table er user_id,follower table er user_id,tweet er id
        );
    }
    public function likes(){
      return  $this->hasMany(Like::class);
    }
    public function retweets()
    {
        return $this->hasMany(Tweet::class)
            ->where('type', TweetType::RETWEET)
            ->orWhere('type', TweetType::QUOTE);
    }
}
