@section('side')
<div class="container">
	<div class="imagecontainer">
	<img src="{{ URL::to('/') }}/uploads/avatars/{{Auth::user()->avatar}}">
	</div>
	<div>
		<p>Welcome back <span>{{Auth::user()->name}}</span></p>
	</div>
	<div>
		<p>25 CREDITS</p>
	</div>
</div>
<div class="container">
	<div>
		<h2>Recent Activities</h2>
	</div>
	<div>
		<p><span>Lisa</span> added <span>Running</span> to her activities</p>
		<p><span>You</span> and <span>Lisa</span> are pals now, say hi!</p>
		<p><span>Sean</span> added <span>Soccer</span> to his activities</p>
		<p><span>Sean</span> added <span>Table Tennis</span> to his activities</p>
		<p><span>Rachel</span> added <span>Mechelen</span> to her regions</p>
	</div>
</div>
<div class="container">
	<div>
		<h2>My Pals</h2>
	</div>
	<div>
		<a href="/messages">Pascale Van Der Auwera</a>
		<a href="/messages">Robin Willekens</a>
		<a href="/messages">Nicolas Acedo</a>
		<a href="/messages">Jaap Signup</a>
	</div>
</div>
@endsection