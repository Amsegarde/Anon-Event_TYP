@extends('app')

@section('splash')
<div class="parallax-container" id="home">
	<div class="parallax"><img class="responsive-img" src="images/homePage.jpg"></div>
	<div class="caption center-align" style="">
		<h1>Welcome to Anon-Event</h1>
		<p>Here we help you to run, promote and manage your organisation's events.</p>
		<a href="">Find out More</a>
	</div>
</div>
@endsection

@section('content')
<div class="section">
	<div class="row">
		<div class="col s4">
			<h4>???</h4>
		</div>
	</div>
</div>

<div class="divider"></div>

<div class="row">
	@foreach ($events as $event)
	<div class="card small col s4">
		<div class="card-image">
			<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
			<span class="card-title">{{ $event->name }}</span>
		</div>
			<div class="card-content">
			<p>{{ $event->bio }}</p>
		</div>
		<div class="card-action">
			<a href="">Favourite link</a>
			<a href="{{ url('/events/'.$event->id) }}">Tickets link</a>
		</div>
	</div>
	@endforeach
</div>


<!-- Scripts for the home page only -->
<script>
	$(document).ready(function(){
		$('.parallax').parallax();
	});
</script>
@endsection
