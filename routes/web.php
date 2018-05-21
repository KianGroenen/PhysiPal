<?php

use App\User;
use App\Interest;
use Illuminate\Support\Facades\Auth;
use App\Friendship;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

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
Route::get('/users/{user}', function ($id) {
	$user = User::find($id);
    return view('users.profile', compact('user'));
});

// Befriend user
Route::get('/users/{user}/sent', function ($id) {
	//$user = Auth::user();
	$user = User::find(1);
	$recipient = User::find($id);
	$user->befriend($recipient);
    return Redirect::to('users/' . $id)
    ->with('recipient')
    ->with('message', 'Friend request sent successfully.');
});

// Unfriend user
Route::get('/users/{user}/remove', function ($id) {
	//$user = Auth::user();
	$user = User::find(1);
	$recipient = User::find($id);
	$user->unfriend($recipient);
    return Redirect::to('users/' . $id)
    ->with('recipient')
    ->with('message', 'Friend removed successfully.');
});

// See Friend Requests
Route::get('/users/{user}/requests', function ($id) {
	//Put in real user (dummy user 1)
	$senderID = Friendship::where('recipient_id', 1)->where('status', 0)->pluck('sender_id');
	$requests = User::find($senderID);
    return view('notifications.show', compact('requests'));
});

// Accept Friend Requests
Route::get('/users/{user}/accept', function ($id) {
	//$user = Auth::user();
	//Recipient
	$user = User::find(1);
	$sender = User::find($id);
	$user->acceptFriendRequest($sender);
	return Redirect::to('users/' . $user->id . '/requests');
});

// Deny Friend Requests
Route::get('/users/{user}/deny', function ($id) {
	//$user = Auth::user();
	//Recipient
	$user = User::find(1);
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

Route::get('/home', 'HomeController@index')->name('home');
