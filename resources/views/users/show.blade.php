@extends('layouts.app')
@extends('layouts.nav')
@section('content')
	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
	@endif
	<div class="search">
		<form action="/users/search" method="get">
			<input type="text" name="search" id="search">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<select name="sport">
			  <option value="volvo">Volvo</option>
			  <option value="saab">Saab</option>
			  <option value="fiat">Fiat</option>
			  <option value="audi">Audi</option>
			</select>
			<select name="level">
			  <option value="volvo">Volvo</option>
			  <option value="saab">Saab</option>
			  <option value="fiat">Fiat</option>
			  <option value="audi">Audi</option>
			</select>
			<div class="slidecontainer">
	  			<input type="range" min="1" max="160" value="50" class="slider" id="distance">
			</div>
			<input type="submit" class="" name="btnSearch" id="btnSearch" value="search">
		</form>
	</div>
	<ul>
	@foreach ($users as $user)
		<li><a href="/users/{{ $user->id }}">{{ $user->name }}</a> | <a href="/users/{{$user->id}}/sent">Add Friend</a> </li>
	@endforeach
	</ul>
@endsection