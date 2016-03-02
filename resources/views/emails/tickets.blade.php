@extends('email')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
					<hr />
					<h1>Your tickets for {{ $event->name }}</h1>
					<hr />
					@foreach ($mailTickets as $mailTicket)
						<h2>Type: {{ $mailTicket->type }}</h2>
						<h2>Quantity: {{ $mailTicket->quantity }}</h2>
						<h3>Date: {{ $event->start_date }} | Ticket No: {{ $mailTicket->id }}</h3>
						<h2>Location: {{ $event->location }}</h2>
						<hr />
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection