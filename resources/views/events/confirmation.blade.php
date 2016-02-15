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
						<h3>Confirm purchase</h3>
						{!! Form::open(array('url' => 'tickets', 'class' => 'form')) !!}
						{!!  Form::hidden('eventID', $event->id) !!}
						{!!  Form::hidden('request', $request) !!}
						{!!  Form::hidden('quantity', $quantity) !!}
					

							<a href="{{ url('/events/'.$event->id )}}"
							<article id="confirmation">
								<h2>{{ $event->name }}</h2>
								<h7>Quantity: {{ $quantity }}</h7>
								<h7>Date: {{ $event->start_date }}</h7>

							</article></a>

							<div class="form-group">
								{!! Form::submit('Confirm', array('class'=>'btn btn-primary')) !!}
							</div>
						{!! Form::close() !!}
					@endif

				</div>
			</div>
		</div>
	</div>
</div>
@endsection