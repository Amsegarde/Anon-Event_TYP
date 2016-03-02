@extends('email')

@section('content')
<div class="container">


		<h1>{{ $organisaion->name }} presents {{ $event->name }}</h1>

		<h2>{{ $title }}</h2>

		<p>{{ $msg }}</p>

	

</div>
@endsection

