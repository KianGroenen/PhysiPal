@section('navbar')
<nav>
	<!-- Link naar notifications nog aanpassen! -->
	<a href="/users">Find Friends</a> | <a href="/users/{{Auth::id()}}/requests">Notifications</a> | <a href="/messages">Messages</a>
	<form action="/users/search" method="get">
		<input type="text" name="search" id="search">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" class="" name="btnSearch" id="btnSearch" value="search">
	</form>
</nav>
@endsection