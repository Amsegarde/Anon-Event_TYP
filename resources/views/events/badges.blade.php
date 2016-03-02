@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				@if (Auth::guest())
					<p>You must be logged in, in order to view tickets</p>
					<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
				@else
					@foreach ($usersArray as $userArray)
						<div class="badges">
							<h2>{{ $userArray->firstname }} {{ $userArray->lastname }}</h2>
							<h4>General Admission</h4>
						</div>
					@endforeach
				@endif

			</div>
		</div>
	</div>
</div>

@endsection