@section('navbar')
{{-- Navigation --}}
<nav>
	<a href="/newsfeed">Newsfeed</a>
	<a href="/users">Palfinder</a>
	<a href="/users/{{Auth::id()}}">Profile</a>
	<a href="/credits/{{Auth::id()}}">Credits</a>
	<a href="/messages">Messages</a>
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
                                    
</nav>
@endsection

<!-- <form action="/users/search" method="get">
		<input type="text" name="search" id="search">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="submit" class="" name="btnSearch" id="btnSearch" value="search">
	</form> -->