@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Browse Events</div>
						@foreach ($events as $event) 

							<a href="{{ url('/events/'.$event->id )}}"
							<article id="events">
								<h2>{{ $event->name }}</h2>
								<h7>Date: {{ $event->start_date }}</h7>
								<button type="button"><a href="{{ url('/events/'.$event->id )}}">Get Tickets</a></button>

							</article></a>
						@endforeach

			</div>
		</div>
	</div>
</div>


@endsection

@endsection
