@extends('layouts.app')
@section('content')
@foreach ($requests as $request)
		<div>
			<p>{{$request->name}}</p>
			<p>{{$request->email}}</p>
			<a href="/users/{{$request->id}}/accept">Accept Friend Request</a>
			<a href="/users/{{$request->id}}/deny">Deny Friend Request</a>
		</div>
@endforeach
@stop