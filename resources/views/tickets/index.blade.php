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
						@foreach ($tickets as $ticket) 
							<a href="{{ url('/tickets/'.$ticket->id )}}">
								<div class="col s12" style="border: 1px solid #cfdcd5; margin-bottom: 15px;">
									<h2 style="float:left;">{{ $ticket->name }}</h2>
									<p style="float:right;">{!! QrCode::margin(1)->size(100)->generate('Event Name: ' . $ticket->name . ' | Date ' . $ticket->start_date . ' | Location: ' . $ticket->location . ' | Order Number: ' . $ticket->order_number . ' | Qrcode generator') !!}<p>
									<p class="capitalize" style="clear:both;">Type: {{ $ticket->type }}</p>
									<p style="clear:both;">Quantity: {{ $ticket->quantity }}</p>
									<h7 style="clear:both;">Date: {{ $ticket->start_date }} | Order No: {{ $ticket->order_number }}</h7>								
									<h7 style="clear:both;">| Details: {{ $ticket->location }}</h7>


								</div>
							</a>
						@endforeach

					@endif

			</div>
		</div>
	</div>
</div>

@endsection

