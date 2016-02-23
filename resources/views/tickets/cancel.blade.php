@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Your Tickets</div>

					@if (Auth::guest())
						<p>You must be logged in, in order to view tickets</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else
						<div class="input-field">
							{!! Form::open(array('route' => 'cancel_order', 'class' => 'form')) !!}
								{!!  Form::hidden('ticketID', $ticketID) !!}
								{!! Form::submit('Confirm Cancelation', array('class'=>'btn btn-primary', 'route' => 'cancel_order')) !!}
							{!! Form::close() !!}
						</div> 					  

					@endif

			</div>
		</div>
	</div>
</div>

@endsection