<?php

use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api/timeline', 'Api\Timeline\TimelineController@index');

Route::get('/api/tweets', 'Api\Tweets\TweetController@index');
Route::get('/api/tweets/{tweet}', 'Api\Tweets\TweetController@show');
Route::post('/api/tweets', 'Api\Tweets\TweetController@store');
Route::get('/tweet/{tweet}', 'Tweets\TweetController@show');


Route::get('/api/tweets/{tweet}/replies', 'Api\Tweets\TweetReplyController@show');
Route::post('/api/tweets/{tweet}/replies', 'Api\Tweets\TweetReplyController@store');


Route::post('/api/tweets/{tweet}/likes', 'Api\Tweets\TweetLikeController@store');
Route::delete('/api/tweets/{tweet}/likes', 'Api\Tweets\TweetLikeController@destroy');

Route::post('/api/tweets/{tweet}/retweets', 'Api\Tweets\TweetRetweetController@store');
Route::delete('/api/tweets/{tweet}/retweets', 'Api\Tweets\TweetRetweetController@destroy');

Route::post('/api/tweets/{tweet}/quotes', 'Api\Tweets\TweetQuoteController@store');

Route::post('/api/media', 'Api\Media\MediaController@store');
Route::get('/api/media/types', 'Api\Media\MediaTypesController@index');

Route::get('/api/notifications', 'Api\Notifications\NotificationController@index');
Route::get('/notifications', 'Notifications\NotificationController@index');
