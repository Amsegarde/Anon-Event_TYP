@extends('print')

@section('content')

	<div class="row col s12">
		
		@if (Auth::guest())
			<p>You must be logged in, in order to view tickets</p>
			<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
		@else
		 	<div class="capitalize" style="border:1px solid black; text-align: center;">
				<h5>Your tickets for {{ $event->name }}</h5>
						
				<h6>Type: {{ $tickets->type }}</h6>
				<h6>Quantity: {{ $tickets->quantity }}</h6>
				<h6>Date: {{ $event->start_date }} | Order No: {{ $tickets->order_number }}</h6>
				<h6>Location: {{ $event->location }}</h6>
				<div class="visible-print text-center">
					{!! QrCode::margin(1)->size(100)->generate('Event Name: ' . $event->name . ' | Date ' . $event->start_date . ' | Location: ' . $event->location . ' | Order Number: ' . $tickets->order_number . ' | Qrcode generator') !!}
				</div>	
			</div>
		@endif
	</div>
@endsection