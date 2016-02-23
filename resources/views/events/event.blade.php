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
				<div class="col s10 offset-s1">
					<h5 align="middle">Description</h5>
					<div class="divider"></div>
					<p>{!! $event->bio !!}</p>
				</div>

				<div class="divider col s12"></div>

				<div class="col s6">
					<h5>Where</h5>
					<p>{{ $event->location }}</p>
				</div>

				<div class="col s6">
					<h5>When</h5>
					<p>{{ date('F d, Y', strtotime($event->start_date)) }} - {{ date('F d, Y', strtotime($event->end_date)) }}</p>
				</div>
					
					
				@if(auth::guest())
					<h5><a href="{{ url('/auth/login') }}">Login to get tickets</a></h5>
				@else 

						@if ($isAdmin === true)

							<div>
								<h4>Tickets Sold Information</h4>
								<div class="divider"></div>
								<table>
									<th>Type of Ticket</th>
									<th>No. of Tickets Sold</th>

									@if ($tickets->all())
										@foreach ($tickets as $tic)
											<tr>
												<td>{{ $tic->type}}</td>
												<td>{{ $tic->quality }}</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>None</td>
											<td>0</td>
										</tr>
									@endif
									<tr>
										<th>Available Tickets:</th>
										<td>{{$event->avail_tickets}}</td>
									</tr>

								</table>
							</div>

						@else
						<!-- Modal Trigger -->
						  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Get Tickets</a>

						  <!-- Modal Structure -->
						  <div id="modal1" class="modal">
						    	<div class="modal-content">
							    	{!! Form::open(array('url' => 'events/' . $event->id . '/ticket/confirm', 'class' => 'form')) !!}
										{!!  Form::hidden('eventID', $event->id) !!}

										<div class="row">
											<div class="input-field col s4">
									        	<input readonly value="Type" id="disabled" type="text">
									        </div>

											<div class="input-field col s4">
									        	<input readonly value="Price" id="disabled" type="text">
									        </div>

									        <div class="input-field col s4">
									        	<input readonly value="Quantity" id="disabled" type="text">
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
						    </div>
						</div>
						@endif
					
					@endif
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
		    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		    $('.modal-trigger').leanModal();
		  });
	</script>
@endsection