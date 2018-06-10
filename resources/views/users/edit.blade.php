<form action="/users/{{Auth::id()}}" method="POST" enctype="multipart/form-data">
	<label for="name">Name</label>
	<input type="text" name="name" value="{{$user->name}}">
	<label for="email">E-mail address</label>
	<input type="text" name="email" value="{{$user->email}}">
	<label for="password">Password - Leave blank to be unchanged</label>
	<input type="password" name="password">
	<label for="about">About me</label>
	<input type="longtext" name="about" value="{{$user->about}}">
	<label for="photo">Avatar</label>
	<input type="file" name="photo">
	{{ csrf_field() }}
	<input type="submit">
</form>