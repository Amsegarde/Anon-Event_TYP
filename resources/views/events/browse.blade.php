@extends('app')

@section('content')

	<div class="row col s12">
		<h5>Browse Events</h5>

		<div class="row col s3">
			<div class="row">
				{!! Form::open(array('url' => 'events')) !!}

					<div class="input-field col s12">
						{!! Form::label('location', 'location') !!}
						{!! Form::text('location') !!}
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
						<select name="genre">
							<option value="">Category</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($genre as $cat)
								<option value="{{$cat->id}}">{{$cat->type}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s12">
						{!! Form::submit('Search', array('class'=>'btn ')) !!}
					</div>

				{!! Form::close() !!}
			</div>
		</div>

		<div class="col s9">
			@foreach ($events as $event)
			<p>{{ $msg }}</p>
			<div class="card small" id="browse">
				<div class="card-image left" id="browse_card">
					<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
				</div>
				<div class="right-content">
					<div class="card-content">
						<p>Date: {{ $event->start_date }}</p>
						<p>Location: {{ $event->location }}</p>
						<span class="card-title">{{ $event->name }}</span>
					</div>
					<div class="card-action">
						<a href="{{ url('/events/'.$event->id) }}">Get Tickets</a>
					</div>
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