@foreach ($interests as $interest)
<p>Sport</p><p>{{$interest->sport}}</p><p>Level</p><p>{{$interest->pivot->level}}</p><br>
@endforeach
<form action="/interests/store" method="POST">
	<label for="sport">Add a new sport</label>
	<select name="sport">
	@foreach ($is as $i)
		<option value="{{$i->id}}">{{$i->sport}}</option>
	@endforeach
	</select>
	<select name="level">
		<option value="Beginner">Beginner</option>
		<option value="Intermediate">Intermediate</option>
		<option value="Expert">Expert</option>
	</select>
	{{ csrf_field() }}
	<input type="submit">
</form>