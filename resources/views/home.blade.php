@extends('layouts.app')
@extends('layouts.nav')
@extends('layouts.side')
@section('content')
<div class="middle">

{{-- Make a post --}}
<div class="make-post">
<form action="/users/posts/store" method="POST" enctype="multipart/form-data">
	<label for="post"></label>
	<input type="longtext" name="post" id="say-something" placeholder="Tell your pals your latest experience..">
	<input type="file" name="photo" id="add-media-icon" src="../img/add-media.svg">
	{{ csrf_field() }}
	<input type="submit" name="submit" value="Send Post" class="post-something">
</form>
</div>

<div class="post">
{{-- Posts of all users --}}
@foreach ($posts as $post)
@foreach ($users as $user)
	@if ($user->id == $post->userid)
		{{-- The post --}}
		<div class="control-group">
			{{-- User & Content of post --}}
			<h3>{{$user->name}}</h3>
			<label for="post" class="control-label">
				<p class="text-info">{{$post->post}}</p>
			</label> <br/>
			<img src="{{ URL::to('/') }}/uploads/media/{{$post->media}}" class="max-width-upload" alt="">
			{{-- Post Likes --}}
			<h2><small>{{ $post->likes()->count() }} <i class="fa fa-thumbs-up"></i></small></h2>
			<p>
		    @foreach ($post->likes as $user)
		        {{ $user->name }}, 
		    @endforeach
			<span>likes this</span></p>
		    @if ($post->isLiked)
		        <a href="{{ route('post.like', $post->id) }}"><img src="../img/heart-filled.svg" alt="unlike button" class="like"/></a>
		    @else
		        <a href="{{ route('post.like', $post->id) }}"><img src="../img/heart-like.svg" alt="unlike button" class="like"/></a>
		    @endif
		</div>	
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
			{{-- Controls to open edit field --}}
			@if ($user->id == Auth::id())
				<div class="controls">
				        <a class="edit {{$post->id}}" href="#"><img src="../img/edit-icon.svg" alt="edit button" class="edit"/></a>
				        <a class="cancel {{$post->id}} edit-input" href="#">Cancel</a>
				</div>
			@endif
			<!-- Post comment -->
			<form action="/users/comments/{{$post->id}}/store" method="POST">
				<label for="comment"></label>
				<input type="longtext" name="comment">
				{{ csrf_field() }}
				<input type="submit" name="submit" value="Post Comment">
			</form>
		{{-- Comments for each post --}}
		@foreach ($comments as $comment)
			@if ($post->id == $comment->postid)
				<div class="comment-section">
					{{-- User & Content of comment --}}
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
					{{-- Controls to open edit field --}}
					@if ($user->id == Auth::id())
					<div class="controls">
					        <a class="edit {{$comment->id}}" href="">Edit</a>
					        <a class="cancel {{$comment->id}} edit-input" href="">Cancel</a>
					</div>
					@endif
				</div>
			@endif
		@endforeach
	@endif
@endforeach
@endforeach
</div>
</div>
@stop