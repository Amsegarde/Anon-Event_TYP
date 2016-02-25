@extends('app')

@section('content')

	<div class="row col s12">
		<h5>Browse Events</h5>

		<div class="row col s12">
			<div class="row">
				{!! Form::open(array('url' => 'events')) !!}
					<div class="input-field col s2">
						<select name="location">
							<option value="">Location</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($search as $event)
								<option value="{{$event->location}}">{{$event->location}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s2">
						<select name="price">
							<option value="">Price</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($search as $event)
								<option value="{{$event->price}}">{{$event->price}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s2">
						<select name="date">
							<option value="">Date</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($search as $event)
								<option value="{{$event->start_date}}">{{$event->start_date}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s2">
						<select name="genre">
							<option value="">Genre</option>
							<!--look into passing org id along with form even though its not displayed-->
							@foreach ($events as $event)
								<option value="{{$event->genre}}">{{$event->genre}}</option>
							@endforeach
						</select>
					</div>

					<div class="input-field col s4">
						{!! Form::submit('Search', array('class'=>'btn indigo lighten-1')) !!}
					</div>

				{!! Form::close() !!}
			</div>
		</div>


		@foreach ($events as $event)
			<a href="{{ url('/events/'.$event->id) }}">
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
			</a>

		@endforeach
	</div>
@endsection