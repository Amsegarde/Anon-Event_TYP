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
	<div class="row" id="event_body" style="margin-top: -60px; background: white;">
		<div class="col s12">
			<div class="row">
				@if ($isAdmin === true)
					<ul class="tabs">
						<li class="tab col s3"><a href="#desc">Description</a></li>
						<li class="tab col s3"><a href="#tix">Ticket Information</a></li>
						<li class="tab col s3"><a href="#edit">Editor</a></li>
						<li class="tab col s3"><a class="waves-effect waves-light btn modal-trigger" href="#modal2">Contact Attendees</a></li>
						
					</ul>
				@endif
				<div id="desc">
					<div class="col s10 offset-s1">
						<h5 align="middle">Description</h5>
						<div class="divider"></div>
						<p>{!! $event->bio !!}</p>
					</div>

					<!-- Itinerary -->
					<div class="col s12">
							@foreach ($itin as $it)
								<div class="col s8 offset-s2">
									<h5 align="middle">{!! $it->name !!}</h5>
									<p>Date: {{ $it->date }}</p> 
									<p>Time: {{ $it->time }}</p>
									<p>{{ $it->blurb }}</p>
									<p>The Cost of the extra event is €{{ $it->cost }}</p>
									<p>There is limited spaces to this event, {{ $it->capacity }} tickets are remaining</p>
								</div>
							@endforeach
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
				</div>
					
					
				@if(auth::guest())
					<div class="col s12">
						<h4>Available Tickets</h4>
							<table>
								<th>Type</th>
								<th>Price</th>
								@foreach ($tickets as $tic)
									<tr>
										<td>{{ $tic->type }}</td>
										<td>{{ $tic->price }}</td>
									</tr>
								@endforeach
							</table>
					</div>
					<div class="col s12"><h5><a href="{{ url('/auth/login') }}">Login to get tickets</a></h5></div>
				@else 

					@if ($isAdmin === true)
						<div id="tix" class="col s12">
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
							

						<div class="row" id="edit">
							<h4>Edit your Event</h4>
							<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>

							{!! Form::open(array('route' => 'create_store', 'class' => 'form', 'files'=>true)) !!}
								<div class="row">
									<!-- Event Information -->
									<h5 class="title col s12">Event Information</h5>
									<div class="divider col s12"></div>

									<div class="input-field col s12">
										{!! Form::label('Event Name') !!}
										{!! Form::text('name', 
														$event->name, 
														array('required'
														)) !!}
									</div>
									
										<div class="input-field col s12">
											<textarea name="bio" id="bio" class="materialize-textarea" length="2000">{{ $event->bio }}</textarea>
										</div>
									<div id="dates">
										<div class="input-field col s6">
										<input type="date" class="start_datepicker" name="start_date[]" placeholder="Start Date">
										</div>
						
										<div class="input-field col s6">
											<input type="date" class="end_datepicker" name="end_date[]" placeholder="End Date">
										</div>
									</div>

									<div class="location[]" id="x">
										<div class="input-field col s12">
										    {!! Form::label('Enter The Location Of Your Event') !!}
										    {!! Form::text('location[]', 
										    				$event->location, 
										      				array('required', 
										         		    'class'=>'form-control', 
										          		    'placeholder'=>'Enter The Location Of Your Event')) !!}
										</div>

									<div class='input-field col s6'>
										{!! Form::select('scope', ['Select a Scope', 'None', 'Local', 'Regional', 
												'National'], $event->scope) !!}
									</div>


									<div class='input-field col s6'>
										{!! Form::select('genre', ['Select a Category', 'Music', 'Sport', 
											'Theatre', 'Convention',
											'Course', 'Conference', 'Seminar', 'Gaming', 'Party', 'Screening', 
											'Tour', 'Other'], $event->genre) !!}
									</div>

									<!-- Event Image upload -->

									<p>Display image here!!</p>
									<h5 class="title col s12">Change Event Image</h5>
									<div class="divider col s12"></div>

									<div class="file-field input-field col s12">
										<div class="btn indigo lighten-1">
											<span>Upload Event Image</span>
											<input name="image" type="file">
										</div>				
										<div class="file-path-wrapper">
											<input class="file-path validate type="text>
										</div>
									</div>

									<!-- Tickets -->
									<h5 class="title col s12">Tickets Information</h5>
									<div class="divider col s12"></div>

									<div class="input-field col s6">
										{!! Form::label('Enter The Number Of Tickets') !!}
										{!! Form::input('number', 'no_tickets', 
													$event->no_tickets, 
													array('required')) !!}
									</div>

									<p>Display tickets and edit ability and itinerary stuff</p>
										
										<!-- Submit Button -->
									<div class="input-field col s12">
										<!-- {!! Form::submit('Update Event!', array('class'=>'btn indigo lighten-1')) !!} -->
									</div>
								</div>
							{!! Form::close() !!}
						</div>
					</div>

					<!-- CONTACT ATTENDEES -->
					<div id="modal2" class="modal">
				    	<div class="modal-content">
					    	<h4>Contact Attendees</h4>

							<ul>
							    @foreach($errors->all() as $error)
							        <li>{{ $error }}</li>
							    @endforeach
							</ul>

							{!! Form::open(array('route' => 'contact_attendees', 'class' => 'form')) !!}
								{!! Form::hidden('eventID', $event->id) !!}
								{!! Form::hidden('organisationID', $organisation->id) !!}

								<div class="form-group">
								    {!! Form::label('Title') !!}
								    {!! Form::text('title', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Title')) !!}
								</div>

								<div class="form-group">
								    {!! Form::label('Message') !!}
								    {!! Form::textarea('message', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Message')) !!}
								</div>

								<div class="form-group">
								    {!! Form::submit('Send', 
								      array('class'=>'btn btn-primary')) !!}
								      <a href="{{ url('/events/'.$event->id) }}">Cancel</a>
								</div>

							{!! Form::close() !!}
					    </div>
					</div>

					@else
						<!-- Modal Trigger -->
						<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Get Tickets</a>

						<!-- Modal Structure -->
						<div id="modal1" class="modal">
					    	<div class="modal-content">
						    	{!! Form::open(array('url' => 'events/' . $event->id . '/ticket/confirm', 'class' => 'form')) !!}
									{!!  Form::hidden('eventID', $event->id) !!}
									{!!  Form::hidden('eventName', $event->name) !!}

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
													'0',
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

		$(document).ready(function(){
			$('ul.tabs').tabs('select_tab', 'tab_id');
		});

		// For the Rich Text Editor
		CKEDITOR.replace( 'bio' );
	</script>
@endsection