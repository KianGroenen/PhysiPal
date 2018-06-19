@section('side')
<div class="right">
    <div class="profile">
        <div class="imagecontainer">
        <img src="{{ URL::to('/') }}/uploads/avatars/{{Auth::user()->avatar}}">
        </div>
        <div class=text-right>
            <p>Welcome back <br/><span>{{Auth::user()->name}}</span><br/><img src="../img/coins.svg" alt="coin icon"/> 25 CREDITS</p>
        </div>
    </div>
    <div class="activities">
        <div class="title">
            <h2>RECENT ACTIVITIES</h2>
        </div>
        <div class="pal-activities">
            <p><img src="../img/running.svg" alt="running icon"/><span class="purple">Lisa</span> added <span class="purple">Running</span> to her activities</p><br/>
            <p><img src="../img/soccer.svg" alt="soccer icon"/><span class="purple">Sean</span> added <span class="purple">Soccer</span> to his activities</p><br/>
            <p><img src="../img/table-tennis.svg" alt="table tennis icon"/><span class="purple">Sean</span> added <span class="purple">Table Tennis</span> to his activities</p><br/>
            <p><img src="../img/location-icon.svg" alt="location icon"/><span class="purple">Rachel</span> added <span class="purple">Mechelen</span> to her regions</p><br/>
            <p><img src="../img/pals-icon.svg" alt="pal icon"/><span class="purple">You</span> and <span class="purple">Lisa</span> are pals now, say hi!</p>
        </div>
    </div>
    <div class="pals">
        <div class="title">
            <h2>MY PALS</h2>
        </div>
        <div class="pal-profiles">
            <a href="/messages"><img src="../img/david.png" alt="profile pic"/>David Doe</a><br/><br/>
            <a href="/messages"><img src="../img/john.png" alt="profile pic"/> John Doe</a><br/><br/>
            <a href="/messages"><img src="../img/jane.png" alt="profile pic"/>Jane Doe</a><br/><br/>
            <a href="/messages"><img src="../img/rachel.png" alt="profile pic"/>Rachel Doe</a>
        </div>
    </div>
</div>
@endsection