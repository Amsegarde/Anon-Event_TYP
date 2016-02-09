@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Browse Events</div>
						@foreach ($events as $event) 
							<article >
								<h2><a{{ $event->name }}</h2>
								<h7>Date: {{ $event->date }}</h7>
								<h7>Details: {{ $event->bio }}</h7>

								<button type="button"><a href="{{ url('/events/eventDetails/{!!$event->event_id!!}') }}">Get Tickets</a></button>
							</article>
						@endforeach

			</div>
		</div>
	</div>
</div>

@endsection
