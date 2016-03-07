@extends('app')

@section('splash')
@if ($event->image != null)
	<div class="parallax-container">
		<div class="parallax"><img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}"></div>
		<div class="caption center-align" style="margin-top:200px;">
			<h1 class="event_title">{!! $event->name !!}</h1>
			<h5><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h5>
		</div>
	</div>
@else
	<div class="section indigo lighten-3" id="event_blank">
		<div class="caption center-align">
			<h1 class="event_title">{!! $event->name !!}</h1>
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
							@foreach ($itinArrays as $itinArray)
								<div class="col s8 offset-s2">
									<h5 align="middle">{!! $itinArray->name !!}</h5>
									<p>Date: {{ $itinArray->date }}</p> 
									<p>{{ $itinArray->blurb }}</p>
									@if($itinArray->cost > 0)
										<p>The Cost of the extra event is €{{ $itinArray->cost }}</p>
									@endif
									@if($itinArray->capacity > 0)	
										<p>There are limited spaces to this event, {{ $itinArray->capacity }} tickets are remaining</p>
									@else
										<p>Sold out!</p>
									@endif
								</div>
							@endforeach
					</div>

					<div class="col s12">
					{!! Form::open(array('url'=>'vote','method'=>'POST', 'class'=>'col s12')) !!}
						<div class="col s6">
							<h5>Where</h5>
							
							@if ($event->location=="To Be Decided")
								<select name="location_vote">
									<option value="">Vote on locations</option>
									@foreach ($locationSuggs as $suggestion)
									<option value="{{$suggestion->id}}">{{$suggestion->location}}</option>
									@endforeach
								</select>			
							@else
								<p>{{ $event->location }}</p>
								<div id="locationField">
	      							<input id="autocomplete2" placeholder="Enter your address"
	             					onFocus="geolocate()" name="location" type="text">
	             					<input type="button" class="btn" onclick="loadMap()" value="Get Directions">
	   			 				</div>
	   			 				<div id ="map"></div>
		   			 				
							@endif
						</div>

						<div class="col s6">
							<h5>When</h5>
							@if (date('F d, Y', strtotime($event->start_date)) != "January 01, 1970")
								<p>{{ date('F d, Y', strtotime($event->start_date)) }} - {{ date('F d, Y', strtotime($event->end_date)) }}</p>
							@else	
								<select name="date_vote">
									<option value="">Vote on dates</option>
										@foreach ($dateSuggs as $dsuggestion)
											<option value="{{$dsuggestion->id}}">{{ date('F d, Y', strtotime($dsuggestion->start_date)) }} - {{ date('F d, Y', strtotime($dsuggestion->end_date)) }}</option>
										@endforeach
								</select>	
							@endif
						</div>
						{!!  Form::hidden('eventID', $event->id) !!}
						@if($voteOpen == 1)
							{!! Form::submit('Vote', array('class'=>'btn')) !!}
						@else
							<p>Your vote has been logged</p>
						@endif
						{!! Form::close() !!}
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
					@if ($isAdmin != true)
						<a class="btn col s6 offset-s3 modal-trigger" href="#modal1">Get Tickets</a>
					@endif
				</div>

					@if ($isAdmin == true)
						<div id="tix" class="col s12">
							<a class="btn modal-trigger" href="#modal2">Contact Attendees</a>
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
							<table>
							@if($locationSuggs != null)
								{!! Form::open(array('url'=>'close_loc_vote','method'=>'POST', 'class'=>'col s12')) !!}
									{!! Form::hidden('id', $event->id) !!}
									<tr><th>Location Suggestions</th><th>Votes</th><th>{!! Form::submit('Finalise Location', array('class'=>'btn')) !!}</th></tr>
								@foreach($locationSuggs as $sug)
									<tr><td>{{$sug->location}}</td><td>{{$sug->votes}}</td><td><input value="{{$sug->location}}"name="location" type="radio" id="{{$sug->location}}"/><label for="{{$sug->location}}"></label></td>
									</tr>
								@endforeach
								{!! Form::close() !!}
							@endif
							@if(count($dateSuggs)>0)
									
								{!! Form::open(array('url'=>'close_date_vote','method'=>'POST', 'class'=>'col s12')) !!}
									{!! Form::hidden('id', $event->id) !!}
									<tr><th>Date Suggestions</th><th>Votes</th><th>{!! Form::submit('Finalise Date', array('class'=>'btn')) !!}</th></tr>
								@foreach($dateSuggs as $dsug)
									<tr><td>{{$dsug->start_date}} - {{$dsug->end_date}}</td><td>{{$dsug->votes}}</td><td><input name="dateId" type="radio" value="{{$dsug->id}}" id="{{$dsug->start_date}}"/><label for="{{$dsug->start_date}}"></label></td></tr>
									
								@endforeach
								{!! Form::close() !!}
							@endif
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
									<div class="input-field col s6">
									<input type="date" class="start_datepicker" name="start_date[]" placeholder="Start Date">
									</div>
					
									<div class="input-field col s6">
										<input type="date" class="end_datepicker" name="end_date[]" placeholder="End Date">
									</div>

									<div class="input-field col s12" id="locationField">
				      					<input id="autocomplete" placeholder="Enter The Location Of Your Event"
				             			onFocus="geolocate()" name="location" type="text"></input>
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
										<div class="btn">
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

										<!-- Submit Button -->
									<div class="input-field col s12">
										<!-- {!! Form::submit('Update Event!', array('class'=>'btn')) !!} -->
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

							{!! Form::open(array('route' => 'contact_attendees')) !!}
								{!! Form::hidden('eventID', $event->id) !!}
								{!! Form::hidden('organisationID', $organisation->id) !!}

								<div class="input-field">
								    {!! Form::label('Title') !!}
								    {!! Form::text('title', null, 
								        array('required', 
								               
								              'placeholder'=>'Title')) !!}
								</div>

								<div class="input-field">
								    {!! Form::label('Message') !!}
								    {!! Form::textarea('message', null, 
								        array('required', 
								            	'class' => 'materialize-textarea',
								            	'placeholder'=>'Message')) !!}
								</div>

								<div class="input-field">
								    {!! Form::submit('Send', 
								      array('class'=>'btn')) !!}
								      <a href="{{ url('/events/'.$event->id) }}">Cancel</a>
								</div>

							{!! Form::close() !!}
					    </div>
					</div>

					@else

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
													null
													) !!}
											</div>
										</div>
									@endforeach
									
									@foreach($itinArrays as $itinArray)
										@if ($itinArray->prebooked = 1)
											<div class="row">
												<div class="input-field col s4">
										        	<input readonly name="name[]" value="{!! $itinArray->name !!}" id="disabled" type="text">
										        </div>
												<div class="input-field col s4">
										        	<input readonly name="cost[]" value="{!! $itinArray->cost !!}" id="disabled" type="text">
										        </div>
										        {!! form::hidden('itinerary_id[]', $itinArray->id) !!}
										        <div class='input-field col s4'>
													{!! Form::select('amount[]', [
														'0',
														'1', 
														'2', 
														'3',
														'4',
														'5',
														'6'], 
														null
														) !!}
												</div>
											</div>
										@endif
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
<script>
	function loadMap(){
		var origin = document.getElementById('autocomplete2').value;
		var map = document.getElementById('map');
		map.innerHTML = '<iframe width="450" height="300" frameborder="0" style="border:0"src="https://www.google.com/maps/embed/v1/directions?origin='+origin+'&destination={{$event->location}}&key={{env("API_KEY")}}" allowfullscreen></iframe>';
	}
</script>
	<script type="text/javascript">

		$(document).ready(function(){
			// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
			// Datepicker working - uses pickadate.js

		$('.start_datepicker').pickadate({
			selectMonths: false, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year
			min: true
		});

		$('.end_datepicker').pickadate({
			selectMonths: false, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year
			min: true
		});
		$('ul.tabs').tabs('select_tab', 'tab_id');
		});
		
		// For the Rich Text Editor
		CKEDITOR.replace( 'bio' );

	</script>
@endsection
