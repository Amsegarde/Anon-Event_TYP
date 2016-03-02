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
						<h3>Date: {{ $event->start_date }} | Order No: {{ $mailTicket->order_number }}</h3>
						<h2>Location: {{ $event->location }}</h2>
						<div class="visible-print text-center">
							<img src="{!!$message->embedData(QrCode::format('png')->margin(1)->size(165)->generate('Event Name: ' . $event->name . ' | Date ' . $event->date . ' | Location: ' . $event->location . ' | Order Number: ' . $mailTicket->order_nunber . ' | Qrcode generator'), 'QrCode.png', 'image/png')!!}">
							   
						</div>	
						<a href="{{ url('/tickets/'.$mailTicket->id )}}">View your tickets on Anon-Event!</a>
						<hr />
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection