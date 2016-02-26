@extends('email')

@section('content')
	<div class="container">

		<hr />
		<h1>{{ $organisation->name }}</h1>
		<hr />

		<h2>{{ $title }}</h2>

		<p>{{ $msg }}</p>

	

	</div>
@endsection

