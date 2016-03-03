@extends('app')

@section('content')

	@if (Auth::guest())
		<p>You must be logged in, in order to view tickets</p>
		<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
	@else
		@foreach ($organisations as $organisation) 
			<article>
				<a href="{{ url('organisation/' .$organisation->id) }}">
					<h2>{{ $organisation->name }}</h2>
				</a>
			</article>
		@endforeach

	@endif


@endsection
