<?php

use App\User;
use App\Interest;
use Illuminate\Support\Facades\Auth;
use App\Friendship;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Newsfeed
Route::get('/', 'PostController@index')->middleware('auth');
Route::get('/newsfeed', 'PostController@index')->middleware('auth');

// Search ALL users
Route::get('/users', function () {
	$users = User::all();
    return view('users.show', compact('users'));
});

// Filter users
Route::get('/users/search', function (Request $request) {
	$param = $request->input('search');
	$firstChar = substr($param, 0, 1);
	$rest = substr($param, 1);
	if ($firstChar == '#') {
		$temp = DB::table('users')->join('usersInterests', 'users.id', '=', 'usersInterests.userid')->leftJoin('interests', 'interests.id', '=', 'usersInterests.interestid')->get();
		$users = $temp->where('sport', $rest);
	} else {
		$users = User::where('name', $param)->get();
	};
	return view('users.show', compact('users'));
});

// Profile page
Route::get('/users/{id}', 'PostController@show');
Route::post('/users/{id}', 'UserController@update');
Route::get('/users/{id}/edit', 'UserController@edit');
Route::get('interests', 'InterestController@index');
Route::post('interests/store', 'InterestController@store');

// Frieded user
Route::get('/users/{user}/friends', function ($id) {
	$user = User::find($id);
	$friendID = Friendship::where('recipient_id', $id)->where('status', 1)->pluck('sender_id');
	$friends = User::find($friendID);
	return view('users.profile', compact('friends', 'user'));
});

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

// Accept Friend Requests
Route::get('/users/{user}/accept', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//Recipient
	//$user = User::find(1);
	$sender = User::find($id);
	$user->acceptFriendRequest($sender);
	return Redirect::to('users/' . $user->id . '/requests');
});

// Deny Friend Requests
Route::get('/users/{user}/deny', function ($id) {
	$userid = Auth::id();
	$user = User::find($userid);
	//Recipient
	//$user = User::find(1);
	$sender = User::find($id);
	$user->denyFriendRequest($sender);
	return Redirect::to('users/' . $user->id . '/requests');
});

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});










Auth::routes();
