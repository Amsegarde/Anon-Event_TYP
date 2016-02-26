@extends('app')

@section('content')

	<div class="row col s12">
		<h5>Browse Events</h5>

		<div class="row col s3">
			<div class="row">
				{!! Form::open(array('url' => 'events')) !!}

					<div class="input-field col s12">
						Change to Jonny's geolocation thing!
						<select name="location">
							<option value="">Location</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($search as $event)
								<option value="{{$event->location}}">{{$event->location}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s12">
						<p class="range-field">
							Max Price
					    	<input type="range" name='price' id="test5" min="0" max="100" />
					    </p>
					</div>

					<div class="input-field col s12">
						<label for="datepicker">After what Date?</label>
						<input type="date" class="datepicker" name="date">
					</div>

					<div class="input-field col s12">
						Change to reading from catagories table
						<select name="genre">
							<option value="">Genre</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($search as $event)
								<option value="{{$event->genre}}">{{$event->genre}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s12">
						{!! Form::submit('Search', array('class'=>'btn indigo lighten-1')) !!}
					</div>

				{!! Form::close() !!}
			</div>
		</div>

		<div class="col s9">
			@foreach ($events as $event)
			<div class="card small col s6">
				<div class="card-image">
					<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
					<span class="card-title">{{ $event->name }}</span>
				</div>
					<div class="card-content">
					<p>Date: {{ $event->start_date }}</p>
					<p>{!! $event->bio !!}</p>
				</div>
				<div class="card-action">
					<a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
					<a href="{{ url('/events/'.$event->id) }}">Get Tickets</a>
				</div>
			</div>
			@endforeach
		</div>

		
	</div>


	<script>
		$(document).ready(function() {
			// Datepicker working - uses pickadate.js
			$('.datepicker').pickadate({
				selectMonths: false, // Creates a dropdown to control month
				selectYears: 15, // Creates a dropdown of 15 years to control year
				min: true
			});
		});
	</script>
@endsection