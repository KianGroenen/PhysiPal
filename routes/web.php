<?php

use App\User;
use App\Interest;
use Illuminate\Support\Facades\Auth;
use App\Friendship;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Geo Location
Route::post('/updateLocation', 'LocationController@updateLocation');

// Likes
Route::get('post/like/{id}', ['as' => 'post.like', 'uses' => 'LikeController@likePost']);

// Newsfeed
Route::get('/', 'PostController@index')->middleware('auth');
Route::get('/newsfeed', 'PostController@index')->middleware('auth');
Route::post('/users/posts/store', 'PostController@store')->middleware('auth');
Route::post('/users/posts/{id}/update', 'PostController@update')->middleware('auth');
Route::delete('/users/posts/{id}/delete', 'PostController@destroy')->middleware('auth');
Route::post('/users/comments/{id}/store', 'CommentController@store')->middleware('auth');
Route::post('/users/comments/{id}/update', 'CommentController@update')->middleware('auth');
Route::delete('/users/comments/{id}/delete', 'CommentController@destroy')->middleware('auth');
Route::delete('/interests/{id}/delete', 'InterestController@destroy')->middleware('auth');

Route::get('/credits/{id}', function ($id) {
	return view('credits');
});

// Search ALL users
Route::get('/users', function () {
	$users = User::all();
	$interests = Interest::all();
    return view('users.show', compact('users', 'interests'));
})->middleware('auth');

// Filter users
Route::get('/users/search', 'SearchController@filter');

// Profile page
Route::get('/users/{id}', 'PostController@show')->middleware('auth');
Route::post('/users/{id}', 'UserController@update')->middleware('auth');
Route::get('/users/{id}/edit', 'UserController@edit')->middleware('auth');
Route::get('/users/{id}/interests', 'InterestController@index')->middleware('auth');
Route::post('/users/{id}/interests/store', 'InterestController@store')->middleware('auth');

// Frieded user
Route::get('/users/{user}/friends', function ($id) {
	$user = User::find($id);
	$friendID = Friendship::where('recipient_id', $id)->where('status', 1)->pluck('sender_id');
	$friends = User::find($friendID);
	return view('users.profile', compact('friends', 'user'));
})->middleware('auth');

// Befriend user
Route::get('/users/{user}/sent', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//$user = User::find(1);
	$recipient = User::find($id);
	$user->befriend($recipient);
    return Redirect::to('users/' . $id)
    ->with('recipient')
    ->with('message', 'Friend request sent successfully.');
});

// Unfriend user
Route::get('/users/{user}/remove', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//$user = User::find(1);
	$recipient = User::find($id);
	$user->unfriend($recipient);
    return Redirect::to('users/' . $id)
    ->with('recipient')
    ->with('message', 'Friend removed successfully.');
});

// See Friend Requests
Route::get('/users/{user}/requests', function ($id) {
	//Put in real user (dummy user 1)
	$senderID = Friendship::where('recipient_id', Auth::id())->where('status', 0)->pluck('sender_id');
	$requests = User::find($senderID);
	$user = User::find($id);
    return view('users.profile', compact('requests', 'user'));
});

// See Pending Requests
Route::get('/users/{user}/pending', function ($id) {
	//Put in real user (dummy user 1)
	$recipientID = Friendship::where('sender_id', Auth::id())->where('status', 0)->pluck('recipient_id');
	$pending = User::find($recipientID);
	$user = User::find($id);
    return view('users.profile', compact('pending', 'user'));
});

// Accept Friend Requests
Route::get('/users/{user}/accept', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//Recipient
	//$user = User::find(1);
	$sender = User::find($id);
	$user->acceptFriendRequest($sender);
	return back();
});

// Cancel Friend Requests
Route::get('/users/{user}/cancel', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//Recipient
	//$user = User::find(1);
	$sender = User::find($id);
	$sender->denyFriendRequest($user);
	return back();
});

// Deny Friend Requests
Route::get('/users/{user}/deny', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//Recipient
	//$user = User::find(1);
	$sender = User::find($id);
	$user->denyFriendRequest($sender);
	return back();
});

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});










Auth::routes();
