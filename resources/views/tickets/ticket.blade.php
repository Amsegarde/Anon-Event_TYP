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
						<article style="background-color:pink">
							<h2>{{ $event->name }}</h2>
							<h4><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h4>
							<h4>Type: {{ $ticket->type }}</h4>
							<h4>Quantity: {{ $ticket->quantity }}</h4>
							<h5>Date: {{ $event->start_date }} | Ticket No: {{ $ticket->id }}</h5>
							<h5>Location: {{ $event->location }}</h5>

							<div class="input-field">
								{!! Form::open(array('url' => 'tickets/' . $ticket->id . '/cancel', 'class' => 'form')) !!}
									{!!  Form::hidden('ticketID', $ticket->id) !!}
									{!! Form::submit('Cancel Order', array('class'=>'btn btn-primary')) !!}
								{!! Form::close() !!}
							</div> 

							<div class="input-field">
								{!! Form::submit('Print Tickets', array('class'=>'btn btn-primary')) !!}
							</div>

							<div class="input-field">
								{!! Form::submit('Contact Organisation', array('class'=>'btn btn-primary')) !!}
							</div>

						</article>					  

					@endif

			</div>
		</div>
	</div>
</div>

@endsection