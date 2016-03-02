@extends('app')

@section('splash')
<div class="parallax-container" id="home">
	<div class="parallax">
	<div class="slider">
    <ul class="slides">
      <li>
        <img class="responsive-img" src="images/conferenceSplash.jpg"> <!-- random image -->
        <div class="caption center-align">
          <h3>Get Organising</h3>
          <h5 class="light grey-text text-lighten-3">Promote, manage and sell your organisation's events</h5>
        </div>
      </li>
      <li>
        <img class="responsive-img" src="images/foodSplash.jpg"> <!-- random image -->
        <div class="caption left-align">
          <h3>Promote Your  Organisation</h3>
          <h5 class="light grey-text text-lighten-3">Get your organisation out there</h5>
        </div>
      </li>
      <li>
        <img class="responsive-img" src="images/sportSplash.jpg"> <!-- random image -->
        <div class="caption right-align">
          <h3>Create Your Own Events</h3>
          <h5 class="light grey-text text-lighten-3">You're the one in charge of your events</h5>
        </div>
      </li>
      <li>
        <img class="responsive-img" src="images/musicSplash.jpg"> <!-- random image -->
        <div class="caption center-align">
          <h3>Sell Your Own Tickets</h3>
          <h5 class="light grey-text text-lighten-3">Sell and manage tickets directly on the site</h5>
        </div>
      </li>
      </div>
    </ul>
  </div>
</div>
<!-- 
	<div class="parallax"><img class="responsive-img" src="images/homePage.jpg"></div>
	<div class="caption center-align" style="">
		<h1>Get Organising</h1>
		<p>Promote, manage and sell your organisation's events.</p>
		<a href="{{ url('about') }}">Find out More</a>
	</div>
</div> -->
@endsection

@section('content')
<div class="section">
	<div class="row">
		<div class="col s4">
			<h4>Upcoming Events</h4>
		</div>
	</div>
</div>

<div class="divider"></div>

<div class="row">
	<h4>Upcoming Events</h4>
	@foreach ($events as $event)
	<div class="card small col s4">
		<div class="card-image">
			<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
			<span class="card-title">{{ $event->name }}</span>
		</div>
			<div class="card-content">
				<p>{!! $event->start_date !!}</p>
				<p>{!! $event->bio !!}</p>
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
