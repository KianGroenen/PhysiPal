@extends('layouts.app')
@extends('layouts.nav')
@section('content')
<form action="/users/posts/store" method="POST">
	<label for="post"></label>
	<input type="longtext" name="post">
	{{ csrf_field() }}
	<input type="submit" name="submit">
</form>


@foreach ($posts as $post)
@foreach ($users as $user)
	@if ($user->id == $post->userid)
		<div class="control-group">
			<h3>{{$user->name}}</h3>
			<label for="post" class="control-label">
				<p class="text-info">{{$post->post}}</p>
			</label>
			<input type="text" class="edit-input" name="post" />
			
			<form action="/users/posts/{{$post->id}}/update" method="POST">
			{{ csrf_field() }}
			<input type="submit" class="edit-input" value="confirm edit">
			</form>
			<form action="/users/posts/{{$post->id}}/delete" method="POST">
				<input type="hidden" name="_method" value="DELETE">
				{{ csrf_field() }}
				<input type="submit" class="edit-input" value="delete">
			</form>
			@if ($user->id == Auth::id())
			<div class="controls">
			        <a class="edit {{$post->id}}" href="#">Edit</a>
			        <a class="cancel {{$post->id}} edit-input" href="#">Cancel</a>
			</div>
			@endif
		</div>
		<!--    @foreach ($comments as $comment)
		    @if ($post->id == $comment->postid)
		    <p>{{$user->name}}</p>
		    <li>{{$comment->comment}}</li>
		    @endif
		    @endforeach-->
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