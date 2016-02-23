@extends('app')

@section('splash')
@if ($event->image != null)
	<div class="parallax-container">
		<div class="parallax"><img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}"></div>
		<div class="caption center-align" style="margin-top:200px;">
			<h1>{!! $event->name !!}</h1>
			<h5><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h5>
		</div>
	</div>
@else
	<div class="section indigo lighten-3" id="event_blank">
		<div class="caption center-align">
			<h1>{!! $event->name !!}</h1>
			<h3><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h3>
		</div>
	</div>
@endif
@endsection

@section('content')
	<div class="row">
		<div class="col s12">
			<div class="row">
				<h4>Description</h4>
				<p>{!! $event->bio !!}</p>

				<h4>Where</h4>
				<p>{{ $event->location }}</p>

				<h4>When</h4>
				<p>{{ $event->start_date }}</p>

				@if(auth::guest())
					<h5><a href="{{ url('/auth/login') }}">Login to get tickets</a></h5>
				@else 

						@if ($isAdmin === true)

							<div>
								
							</div>

						@else
							{!! Form::open(array('url' => 'events/' . $event->id . '/ticket/confirm', 'class' => 'form')) !!}
								{!!  Form::hidden('eventID', $event->id) !!}

								<div class="row">
									<div class="input-field col s4">
							        	<input disabled value="Type" id="disabled" type="text">
							        </div>

									<div class="input-field col s4">
							        	<input disabled value="Price" id="disabled" type="text">
							        </div>

							        <div class="input-field col s4">
							        	<input disabled value="Quantity" id="disabled" type="text">
							        </div>
								</div>

								@foreach ($tickets as $ticket)
								<div class="row">
									<div class="input-field col s4">
							        	<input readonly name="type[]" value="{!! $ticket->type !!}" id="disabled" type="text">
							        </div>

									<div class="input-field col s4">
							        	<input readonly name="price[]" value="{!! $ticket->price !!}" id="disabled" type="text">
							        </div>

							        <div class='input-field col s4'>
										{!! Form::select('quantity[]', [
											'1', 
											'2', 
											'3',
											'4',
											'5',
											'6'], 
											null,
											['class'=>'ticketSelect']) !!}
									</div>
								</div>
							@endforeach

								@if (($event->avail_tickets) === 0 )
									<p>SOLD OUT</p>
								@else
									<div class="input-field">
										{!! Form::submit('Get Tickets', array('class'=>'btn')) !!}
									</div>
									<p>{{ $event->avail_tickets }} Remaining</p>
								@endif

					{!! Form::close() !!}

						@endif
					
					@endif
			</div>
		</div>
	</div>
@endsection