@extends('layouts.app')
@extends('layouts.nav')
@extends('layouts.side')
@section('content')
<div class="middle">
	@if (Session::has('message'))
		<div class="alert alert-success">
			{{Session::get('message')}}
		</div>
	@endif
	{{-- User Search field --}}
	<div class="search">
		<form action="/users/search" method="get">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<select name="sport">
				<option value="Any">Any</option>
			@foreach ($interests as $interest)
				<option value="{{$interest->id}}">{{$interest->sport}}</option>
			@endforeach
			</select>
			<select name="level">
			  <option value="Any">Any</option>
			  <option value="Beginner">Beginner</option>
			  <option value="Intermediate">Intermediate</option>
			  <option value="Expert">Expert</option>
			</select>
			<div class="slidecontainer">
	  			<input type="range" min="1" max="160" value="50" class="slider" id="distance">
			</div>
			<input type="submit" class="" name="btnSearch" id="btnSearch" value="search">
		</form>
	</div>
	<ul>
	{{-- Search Results --}}
	@if (isset($filters))
	@if ($filters->isEmpty())
		<p>Apply filter to view users</p>
	@endif
	@foreach ($filters as $filter)
		<li><a href="/users/{{ $filter->userid }}">{{ $filter->name }}</a> | <a href="/users/{{$filter->id}}/sent">Add Friend</a> </li>
	@endforeach
	@endif
	</ul>
@endsection
</div>