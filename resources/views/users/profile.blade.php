{{-- Using extends to import .php files --}}
@extends('layouts.app')
@extends('layouts.nav')
@extends('layouts.side')
{{-- 'Content' gets 'yielded' in base file, app.blade.php --}}
@section('content')
<div class="middle">
	<div class="profile-page">
		{{-- Profile Page --}}
		<h1>{{$user->name}}</h1>
		<img src="{{ URL::to('/') }}/uploads/avatars/{{$user->avatar}}">
		<p>{{$user->about}}</p>
		{{-- Links towards content on profile page --}}
		{{-- These 2 links will show when it isn't the logged in user --}}
		@if ($user->id != Auth::id())
		<a href="/users/{{$user->id}}/sent">Add Friend</a>
		<a href="/users/{{$user->id}}/remove">Remove Friend</a>
		@endif
		{{-- These 2 links will always show --}}
		<a href="/users/{{$user->id}}">Recent Posts</a>
		<a href="/users/{{$user->id}}/friends">Pals</a>
		{{-- Next 4 links will only show when it's the logged in user (editing posts, account info, etc) --}}
		@if ($user->id == Auth::id())
		<a href="/users/{{$user->id}}/requests">Pal Requests</a>
		<a href="/users/{{$user->id}}/pending">Pending Pals</a>
		@endif
		@if ($user->id == Auth::id())
		<a href="">My Info</a>
		<a href="#">Premium User</a>
		<a href="/users/{{$user->id}}/interests">Sports Added</a>
		<a href="/users/{{$user->id}}/edit">Account Info</a>
		@endif
	</div>
	
	{{-- All posts --}}
	<div class="container">
		@if (isset($posts))
			@if ($posts->isEmpty())
				<p>Make your first post</p>
			@endif
			@foreach ($posts as $post)
				<div class="control-group">
					<h3>{{$user->name}}</h3>
					<label for="post" class="control-label">
						<p class="text-info">{{$post->post}}</p>
					</label>
					<img src="{{ URL::to('/') }}/uploads/media/{{$post->media}}" alt="">
					{{-- Post Likes --}}
					<h2><small>{{ $post->likes()->count() }} <i class="fa fa-thumbs-up"></i></small></h2>
					<p>
				    @foreach ($post->likes as $user)
				        {{ $user->name }}, 
				    @endforeach
					<span>like this!</span></p>
				    @if ($post->isLiked)
				        <a href="{{ route('post.like', $post->id) }}">Unlike</a>
				    @else
				        <a href="{{ route('post.like', $post->id) }}">Like</a>
				    @endif
					{{-- Form to update post --}}
					<form action="/users/posts/{{$post->id}}/update" method="POST">
						<input type="text" class="edit-input" name="post" />
						{{ csrf_field() }}
						<input type="submit" class="edit-input" value="confirm edit">
					</form>
					{{-- Form to delete post --}}
					<form action="/users/posts/{{$post->id}}/delete" method="POST">
						<input type="hidden" name="_method" value="DELETE">
						{{ csrf_field() }}
						<input type="submit" class="edit-input" value="delete">
					</form>
					{{-- Buttons to open edit field --}}
					@if ($user->id == Auth::id())
					<div class="controls">
					        <a class="edit {{$post->id}}" href="#">Edit</a>
					        <a class="cancel {{$post->id}} edit-input" href="#">Cancel</a>
					</div>
					@endif
					{{-- Form to post comment to a post --}}
					<form action="/users/comments/{{$post->id}}/store" method="POST">
						<label for="comment"></label>
						<input type="longtext" name="comment">
						{{ csrf_field() }}
						<input type="submit" name="submit" value="Post Comment">
					</form>
				</div>
				{{-- Comments to that post --}}
				@foreach ($comments as $comment)
				@foreach ($users as $user)
				@if ($user->id == $comment->userid)
			    @if ($post->id == $comment->postid)
			    <div class="control-group">
					<h4>{{$user->name}}</h4>
					<label for="comment" class="control-label">
						<p class="text-info">{{$comment->comment}}</p>
					</label>
				    {{-- Form to update comment --}}
				    <form action="/users/comments/{{$comment->id}}/update" method="POST">
						<input type="text" class="edit-input" name="comment" />
						{{ csrf_field() }}
						<input type="submit" class="edit-input" value="confirm edit">
					</form>
					{{-- Form to delete comment --}}
					<form action="/users/comments/{{$comment->id}}/delete" method="POST">
						<input type="hidden" name="_method" value="DELETE">
						{{ csrf_field() }}
						<input type="submit" class="edit-input" value="delete">
					</form>
					{{-- button to open edit field --}}
					@if ($user->id == Auth::id())
					<div class="controls">
					        <a class="edit {{$comment->id}}" href="#">Edit</a>
					        <a class="cancel {{$comment->id}} edit-input" href="#">Cancel</a>
					</div>
					@endif
				</div>
			    @endif
			    @endif
				@endforeach
				@endforeach
			@endforeach
		@endif
	</div>

	{{-- All pals --}}
	<div class="container">
		@if (isset($friends))
		{{-- ->isEmpty() is always the empty state --}}
		@if ($friends->isEmpty())
			<p>Add some friends in pal finder</p>
		@endif
		@foreach ($friends as $friend)
			<li><a href="/users/{{$friend->id}}">{{$friend->name}}</a></li>
		@endforeach
		@endif
	</div>

	{{-- All pal requests --}}
	<div class="container">
		@if (isset($requests))
		@if ($requests->isEmpty())
			<p>No friend requests at the moment</p>
		@endif
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

	{{-- All pending pals --}}
	<div class="container">
		@if (isset($pending))
		@if ($pending->isEmpty())
			<p>No pending requests at the moment</p>
		@endif
		@foreach ($pending as $p)
		<div>
			<p>{{$p->name}}</p>
			<p>{{$p->email}}</p>
			<a href="/users/{{$p->id}}/cancel">Cancel Friend Request</a>
		</div>
		@endforeach
		@endif
	</div>
	
	{{-- Edit profile --}}
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
			<label for="street">Street and Number</label>
			<input type="text" name="street" value="{{$user->street}}">
			<label for="zipcode">Zip Code</label>
			<input type="text" name="zipcode" id="" value="{{$user->zipcode}}">
			<label for="city">City / Town</label>
			<input type="text" name="city" value="{{$user->city}}">
			<label for="photo">Avatar</label>
			<input type="file" name="photo">
			{{ csrf_field() }}
			<input type="submit">
		</form>
		@endif
	</div>

	{{-- Edit Sports --}}
	<div class="container">
		@if (isset($interests))
		@foreach ($interests as $interest)
			<p>Sport</p><p>{{$interest->sport}}</p><p>Level</p><p>{{$interest->pivot->level}}</p><br>
			{{-- Form to delete Sports --}}
			<form action="/interests/{{$interest->id}}/delete" method="POST">
				<input type="hidden" name="_method" value="DELETE">
				{{ csrf_field() }}
				<input type="submit" value="delete">
			</form>
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
</div>
@stop