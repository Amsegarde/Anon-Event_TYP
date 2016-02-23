@extends('app')

@section('content')
	<div class="row">
		<h1>Create a New Event</h1>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

		{!! Form::open(array('route' => 'create_store', 'class' => 'form', 'files'=>true)) !!}
			<div class="row">
				<!-- Select Organisation -->
				<h5 class="title col s12">Select an Organisation</h5>
				<div class="divider col s12"></div>

				<div class="input-field col s12">
					<select name="organisation">
						<option value="">Select an Organisation</option>
						<!--look into passing org id along with form even though its not displayed-->
						@foreach ($organisations as $organisation)
							<option value="{{$organisation->id}}">{{$organisation->name}}</option>
						@endforeach
					</select>		
				</div>

				<!-- Event Information -->
				<h5 class="title col s12">Event Information</h5>
				<div class="divider col s12"></div>

				<div class="input-field col s12">
					{!! Form::label('Event Name') !!}
					{!! Form::text('name', 
									null, 
									array('required'
									)) !!}
				</div>

				<div class="input-field col s12">
					<textarea name="bio" id="bio" class="materialize-textarea" length="2000"></textarea>
				</div>

				<div class="input-field col s6">
					<input type="date" class="start_datepicker" name="start_date" placeholder="Start Date">
				</div>

				<div class="input-field col s6">
					<input type="date" class="end_datepicker" name="end_date" placeholder="End Date">
				</div>					

				<div class="location" id="x">
					<div class="input-field col s12">
						{!! Form::label('Enter The Location Of Your Event') !!}
						{!! Form::text('location', 
										null, 
										array('required')) !!}
					</div>
					
					<input type="button" class="btn" value="Open to suggestions" onClick="togglePoll(location);">
				</div>

				<div class='input-field col s6'>
					{!! Form::select('scope', ['Select a Scope', 'None', 'Local', 'Regional', 
							'National'], null) !!}
				</div>

				<div class='input-field col s6'>
					{!! Form::select('genre', ['Select a Category', 'Music', 'Sport', 
						'Theatre', 'Convention',
						'Course', 'Conference', 'Seminar', 'Gaming', 'Party', 'Screening', 
						'Tour', 'Other'], null) !!}
				</div>

				<!-- Event Image upload -->
				<h5 class="title col s12">Upload Event Image</h5>
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
								0, 
								array('required')) !!}
				</div>

				<div class="input-field col s6">
					{!! Form::label('Enter The Price Of A Ticket') !!}
					{!! Form::input('number', 'price', 
									0, 
									array('required')) !!}
					
				</div>

				<div class="input-field col s12">
					<table id="dynamic-tickets" class="ticket-table col s12"></table>
					<input type="button" class="btn"value="Add Ticket" onClick="addTicket('dynamic-tickets');">
				</div>

					<div class="form-group">
					    {!! Form::label('Select your tickets') !!}
					</div>



					<!-- Itinery Items -->
				<h5 class="title col s12">Optional Itinerary</h5>
				<div class="divider col s12"></div>

				<div class="input-field col s12">
					<div id="dynamicInput">
					   <!--  Itinerary From divs will go here  -->
					</div>	 
					<input type="button" class="btn"value="Add Itinerary Item" onClick="addInput('dynamicInput');">
				</div>
					
					<!-- Submit Button -->
				<div class="input-field col s12">
					{!! Form::submit('Create Event!', array('class'=>'btn indigo lighten-1')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>

<script type="text/javascript">	
	// For the Rich Text Editor
	CKEDITOR.replace( 'bio' );

    // Select Menu woring
	$(document).ready(function() {
		$('select').material_select();

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
	});

	var nextTicket = 1;
	var ticketCounter = 0;
	var itemElement = 1;
	var counter = 0;
	var limit = 3;

	function addInput(divName){
    	if (counter == limit)  {
        	alert("You may only add " + counter + " inputs");
		}
     	else {
        	var newdiv = document.createElement('div');
        	newdiv.setAttribute('id','itinItem'+counter);
       		//counter++;
        	newdiv.innerHTML =
        				"<div class='input-field col s12'>"+
						"<label for='item["+itemElement+"]'>Name</label>"+
						"<input type='text' name='item["+itemElement+"]'></div>"+
						
						"<div class='input-field col s12'>"+
						"<label for='item["+(itemElement+1)+"]'>Description</label>"+
						"<input type='text' name='item["+(itemElement+1)+"]'></div>"+
						
						"<div class='input-field col s12'>"+
						"<label for='item["+(itemElement+2)+"]'>Time</label>"+
						"<input type='text' name='item["+(itemElement+2)+"]'></div>"+

						"<div class='input-field col s6'>"+
						"<label for='item["+(itemElement+3)+"]'>Cost(optional)</label>"+
						"<input type='number' name='item["+(itemElement+3)+"]'></div>"+

						"<div class='input-field col s6'>"+
						"<label for='item["+(itemElement+4)+"]'>Capacity</label>"+
						"<input type='number' name='item["+(itemElement+4)+"]'></div>"+

						"<div class='input-field col s6'>"+
						"<input type='checkbox' id='checkbox' name='item["+(itemElement+5)+"]' value='true'><label for='checkbox'>Pre-booked?</label></div>"+

						"<div class='input-field col s6'>"+
						"<input type='button' class='btn' value='Remove Itinerary Item' onClick='removeInput(itinItem"+counter+");'></div>";
			counter++;
			itemElement+=6;
        	document.getElementById(divName).appendChild(newdiv);      
    	}
 
	}
 function removeInput(e){
 		e.remove();
 		counter--;
    }
 
    // *********************************************add and remove tickets *************************************
    function addTicket(divName){
    	if (ticketCounter == 10)  {
        	alert("You may only add " + counter + " tickets");
		}
     	else {
     		var newhead = document.createElement('tr');
        	var newrow = document.createElement('tr');
        	newrow.setAttribute('id','ticket' + nextTicket);	
        	newhead.setAttribute('id','tickethead');
       		}
       	if (ticketCounter == 0) {
       		newhead.innerHTML ='<th>Type</th><th>Price</th><th>Remove</th>';
				document.getElementById(divName).appendChild(newhead);				

       	} 
       	newrow.innerHTML =	'<td>'+
       							'<select class="ticketSelect" name="tickets[]">'+
									'<option value="free">Free</option>'+
									'<option value="paid">Paid</option>'+
									'<option value="students">Students</option>'+
									'<option value="oap">OAP</option>'+
									'<option value="early_bird">Early Bird</option>'+
									'<option value="rsvp">R.S.V.P</option>'+
								'</select>'+
							'</td>	'+
							'<td>'+
								'<div class="form-group">'+
									'<input type="number" name="tickets[]" step="0.50" class="form-control" />'+
								'</div>'+
							'</td>'+
							'<td>'+
								'<input type="button" step="0.50" class="btn" value="-" onClick="removeTicket(ticket'+ nextTicket+');" />'+
							'</td>';
       	
        console.log("Ticket number " + nextTicket + " added");	
       				
		//itemElement+=6;
        document.getElementById(divName).appendChild(newrow);  
        
        ticketCounter++;
       	nextTicket++;
       	console.log("Next ticket will be " + nextTicket);
	}

	function removeTicket(e){
		console.log("counter value is " + ticketCounter);
		console.log("ticket number " + ticketCounter + "removed");
 		e.remove();
 		if(ticketCounter ==1){
 			document.getElementById('tickethead').remove();
 		} 
 		
 		ticketCounter--;
 		console.log("There is now " + ticketCounter + " tickets remaining");
    }

    // From here on, styling needs to be added.
 
    var locationPolled = false;
    var numOfSuggestions = 0;


    function togglePoll(e){
    	console.log("add location to poll");
    	if(!locationPolled){
    		locationPolled = true;
    		numOfSuggestions = 1;
    	document.getElementById('x').innerHTML="<div class='form-group' id='locationSuggestion'>"
    										+"<div id='locationSuggestion"+numOfSuggestions+"'>"
    										+"<label for='location'>Enter Location Suggestions</label>"
         									+"<input type='text' name='location[]' class='form-control'>"
         									+"<input type='button' class='btn btn-secondary'value='remove Suggestion' onClick='removeSuggestion(locationSuggestion"+numOfSuggestions+");'>"
           									+"</div>"
           									+"<input type='button' class='btn btn-secondary'value='Add Suggestion' onClick='addSuggestion(locationSuggestion"+numOfSuggestions+");'>"
         									+"</div>"
         									+"<input type='button' class='btn btn-secondary'value='Remove Poll' onClick='togglePoll(location);'>";
    	
    	}else{
    		locationPolled = false;
    		numOfSuggestions = 0;
    		document.getElementById('x').innerHTML="<div class='form-group' id='locationSuggestions'>"
    										+"<label for='location'>Enter Location</label>"
         									+"<input type='text' name='location[]' class='form-control'>"
         									+"</div>"
         									+"<input type='button' class='btn btn-secondary'value='Open to suggestions' onClick='togglePoll(location);'>";

    	}
	}
    function addSuggestion(num){
    		numOfSuggestions++;
    		var nextSuggestion = document.createElement('div');
    		nextSuggestion.innerHTML="<div id='locationSuggestion"+numOfSuggestions+"'>"
    										
         									+"<input type='text' name='location[]' class='form-control'>"
         									+"<input type='button' class='btn btn-secondary'value='remove Suggestion' onClick='removeSuggestion(locationSuggestion"+numOfSuggestions+");'>"
           									+"</div>";



    		num.appendChild(nextSuggestion);
    		console.log("adding suggestiuon");
    }
   	
   	function removeSuggestion(num){
   		if(numOfSuggestions>1){
   			console.log(num);
   			num.remove();
   			numOfSuggestions--;
   		}
   	}


</script>

@endsection
