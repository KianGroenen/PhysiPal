@section('navbar')
{{-- Navigation --}}

<nav class="main-nav">
	<a href="/newsfeed" src="../img/logo.svg" id="logo"><img src="../img/logo.svg" alt="logo physipal"/></a>
	<a href="/newsfeed">NEWSFEED</a>
	<a href="/users">PALFINDER</a>
	<a href="/users/{{Auth::id()}}">PROFILE</a>
	<a href="/credits/{{Auth::id()}}">CREDITS</a>
	<a href="/messages">MESSAGES</a>
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        LOGOUT
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