@extends('layouts.app')
@extends('layouts.nav')
@section('content')
@foreach ($posts as $post)
@foreach ($users as $user)
@if ($user->id == $post->userid)
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
@endif
@endforeach
@endforeach
@stop