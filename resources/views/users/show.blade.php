@extends('layouts.app')
@section('content')
	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
	@endif
	<ul>
	@foreach ($users as $user)
		<li><a href="/users/{{ $user->id }}">{{ $user->name }}</a> | <a href="/users/{{$user->id}}/sent">Add Friend</a> </li>
	@endforeach
	</ul>
@stop