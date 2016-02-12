@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					@if (Auth::guest())
						<p>You must have an account in order to get tickets.</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else
						<h3>Please click button to confirm purchase</h3>
						<button><a href="{{ url('/events/' . $tickets->id . '/ticket/confirm/' . $tickets->quantity) }}">Confirm Ticket</a></button>
					@endif

				</div>
			</div>
		</div>
	</div>
</div>
@endsection