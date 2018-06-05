@extends('layouts.app')
@extends('layouts.nav')
@section('content')
	<h1>{{$user->name}}</h1>
	<img src="uploads/{{$user->avatar}}">
	<p>{{$user->about}}</p>
	@if (!Auth::id() == $user->id)
		<a href="/users/{{$user->id}}/sent">Add Friend</a>
		<a href="/users/{{$user->id}}/remove">Remove Friend</a>
	@endif
	<a href="/users/{{$user->id}}">Recent Posts</a>
	<a href="/users/{{$user->id}}/friends">Pals</a>
	<a href="/users/{{$user->id}}/requests">Friend Requests</a>
	<div class="container">
		@if (isset($posts))
		@foreach($posts as $post)
		<ul>
			<li>{{$user->name}}</li>
			<li>{{$post->post}}</li>
			@foreach ($comments as $comment)
		    @if ($post->id == $comment->postid)
		    <p>{{$user->name}}</p>
		    <li>{{$comment->comment}}</li>
		    @endif
		    @endforeach
		</ul>
		@endforeach
		@endif
	</div>

	<div class="container">
		@if (isset($friends))
		@foreach ($friends as $friend)
			<li>{{$friend->name}}</li>
		@endforeach
		@endif
	</div>

	<div class="container">
		@if (isset($requests))
		@foreach ($requests as $request)
		<div>
			<p>{{$request->name}}</p>
			<p>{{$request->email}}</p>
			<a href="/users/{{$request->id}}/accept">Accept Friend Request</a>
			<a href="/users/{{$request->id}}/deny">Deny Friend Request</a>
		</div>
		@endforeach
		@endif
	</div>

@stop