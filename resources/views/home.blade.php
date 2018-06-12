@extends('layouts.app')
@extends('layouts.nav')
@extends('layouts.side')
@section('content')
{{-- Make a post --}}
<h2>Post something on your wall</h2>
<form action="/users/posts/store" method="POST">
	<label for="post"></label>
	<input type="longtext" name="post">
	{{ csrf_field() }}
	<input type="submit" name="submit" value="Send Post">
</form>

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
			</label>
			
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
				        <a class="edit {{$post->id}}" href="#">Edit</a>
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
		</div>
		{{-- Comments for each post --}}
		@foreach ($comments as $comment)
			@if ($post->id == $comment->postid)
				<div class="control-group">
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
					        <a class="edit {{$comment->id}}" href="#">Edit</a>
					        <a class="cancel {{$comment->id}} edit-input" href="#">Cancel</a>
					</div>
					@endif
				</div>
			@endif
		@endforeach
	@endif
@endforeach
@endforeach
<script type="text/javascript">
	//$('body').on('click', 'a.edit', function() {
	$('a.edit').click(function () {
        var dad = $(this).parent().parent();
        dad.find('label').hide();
        var str = $.trim(dad.find('label').text());
        dad.find('input[type="text"]').val(str);
        dad.find('input[type="text"]').show().focus();
        dad.find('input[type="submit"]').show();
        dad.find('a.cancel').show();
        dad.find('a.delete').show();
    });

	$('a.cancel').click(function (){
		var dad = $(this).parent().parent();
		dad.find('input[type="text"]').hide()
        dad.find('input[type="submit"]').hide();
        dad.find('a.delete').hide();
        $(this).hide();
        dad.find('label').show();
	});
</script>
@stop