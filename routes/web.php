<?php

use App\User;
use App\Auth;
use App\Friendship;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return view('welcome');
});

// Search ALL users
Route::get('/users', function () {
	$users = User::all();
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









