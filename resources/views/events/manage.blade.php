@extends('app')

@section('content')
	<div>
		<h5>Manage Events</h5>
	</div>

	<div class="row">
		@foreach ($events as $event)
			<a href="{{ url('/events/'.$event->id) }}">
				<div class="card small col s4">
					<div class="card-image">
						<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}"> -->
						<span class="card-title">{{ $event->name }}</span>
					</div>
					<h4>{{ $event->name }}</h4>
					<div class="card-content">
						<p>Date: {{ $event->start_date }}</p>
					</div>
					<div class="card-action">
						<a href="{{ url('/events/'.$event->id) }}">Dashboard</a>
					</div>
				</div>
			</a>
		@endforeach
	</div>
@endsection