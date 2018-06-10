@extends('layouts.app')
@extends('layouts.nav')
@section('content')
	<h1>{{$user->name}}</h1>
	{{$user->avatar}}
	<!-- RE-ENABLE WHEN DESIGNING -->
	<!--<img src="{{ URL::to('/') }}/uploads/avatars/{{$user->avatar}}">-->
	<p>{{$user->about}}</p>
	@if ($user->id != Auth::id())
	<a href="/users/{{$user->id}}/sent">Add Friend</a>
	<a href="/users/{{$user->id}}/remove">Remove Friend</a>
	@endif
	<a href="/users/{{$user->id}}">Recent Posts</a>
	<a href="/users/{{$user->id}}/friends">Pals</a>
	<a href="/users/{{$user->id}}/requests">Friend Requests</a>
	@if ($user->id == Auth::id())
	<a href="">My Info</a>
	<a href="#">Premium User</a>
	<a href="/users/{{$user->id}}/interests">Sports Added</a>
	<a href="/users/{{$user->id}}/edit">Account Info</a>
	@endif
	<div class="container">
		@if (isset($posts))
		@foreach($posts as $post)
		<ul>
			<li>{{$user->name}}</li>
			<li>{{$post->post}}</li>
			@foreach ($comments as $comment)
			@foreach ($users as $user)
			@if ($user->id == $comment->userid)
		    @if ($post->id == $comment->postid)
		    <p>{{$user->name}}</p>
		    <li>{{$comment->comment}}</li>
		    @endif
		    @endif
		    @endforeach
		    @endforeach
		</ul>
		@endforeach
		@endif
	</div>

	<div class="container">
		@if (isset($friends))
		@foreach ($friends as $friend)
			<li><a href="/users/{{$friend->id}}">{{$friend->name}}</a></li>
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
	
	<div class="container">
		@if (isset($edit))
		<form action="/users/{{Auth::id()}}" method="POST" enctype="multipart/form-data">
			<label for="name">Name</label>
			<input type="text" name="name" value="{{$user->name}}">
			<label for="email">E-mail address</label>
			<input type="text" name="email" value="{{$user->email}}">
			<label for="password">Password - Leave blank to be unchanged</label>
			<input type="password" name="password">
			<label for="about">About me</label>
			<input type="longtext" name="about" value="{{$user->about}}">
			<label for="photo">Avatar</label>
			<input type="file" name="photo">
			{{ csrf_field() }}
			<input type="submit">
		</form>
		@endif
	</div>

	<div class="container">
		@if (isset($interests))
		@foreach ($interests as $interest)
			<p>Sport</p><p>{{$interest->sport}}</p><p>Level</p><p>{{$interest->pivot->level}}</p><br>
		@endforeach
		<form action="/users/{{$user->id}}/interests/store" method="POST">
			<label for="sport">Add a new sport</label>
			<select name="sport">
			@foreach ($is as $i)
				<option value="{{$i->id}}">{{$i->sport}}</option>
			@endforeach
			</select>
			<select name="level">
				<option value="Beginner">Beginner</option>
				<option value="Intermediate">Intermediate</option>
				<option value="Expert">Expert</option>
			</select>
			{{ csrf_field() }}
			<input type="submit">
		</form>
		@endif
	</div>
@stop