@extends('print')

@section('content')

	<div class="row col s12">
		
		@if (Auth::guest())
			<p>You must be logged in, in order to view tickets</p>
			<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
		@else
			@foreach ($usersArray as $userArray)
				<div class="badges col s5 offset-s1">
					<h4 align="middle">{{ $userArray->firstname }} {{ $userArray->lastname }}</h4>
					<h5 align="middle">{{ $event->name }}</h5>
					<h6 align="middle">General Admission</h6>
				</div>
			@endforeach
		@endif
	</div>



@endsection