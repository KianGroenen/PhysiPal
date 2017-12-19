@extends('layouts.app')
@section('content')
	<img src="uploads/{{$user->avatar}}">
	<ul>
		<li>{{ $user->name }}</li>
		<li>{{ $user->about }}</li>
		<a href="/users/{{$user->id}}/sent">Add Friend</a>
		<a href="/users/{{$user->id}}/remove">Remove Friend</a>
	</ul>
@stop