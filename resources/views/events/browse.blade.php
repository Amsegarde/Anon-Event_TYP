@extends('app')

@section('content')
	<div>
		<h5>Browse Events</h5>
	</div>

	<div class="row">
		@foreach ($events as $event)
		<div class="card small col s4">
			<div class="card-image">
				<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
				<span class="card-title">{{ $event->name }}</span>
			</div>
				<div class="card-content">
				<p>Date: {{ $event->start_date }}</p>
				<p>{{ $event->bio }}</p>
			</div>
			<div class="card-action">
				<a href="">Favourite link</a>
				<a href="{{ url('/events/'.$event->id) }}">Get Tickets</a>
			</div>
		</div>
		@endforeach
	</div>
@endsection