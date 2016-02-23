@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-body">
					<h1>Create Event</h1>

					<ul>
					    @foreach($errors->all() as $error)
					        <li>{{ $error }}</li>
					    @endforeach
					</ul>

					{!! Form::open(array('route' => 'create_store', 'class' => 'form')) !!}

					<div class="form-group">
					    {!! Form::label('Event Name') !!}
					    {!! Form::text('name', 
					    				null, 
					      				array('required', 
					         		    'class'=>'form-control', 
					          		    'placeholder'=>'Event Name')) !!}
					</div>


					<div class="form-group">
							{!! Form::label('organisation', 'Select Organisation') !!}
								<select name="organisation" class="form-control">
								    <option value="0">Select an Organisation</option>
								    	
								    @foreach ($organisations as $organisation)

								    	<option value="{{$organisation->id}}">{{$organisation->name}}</option>
								    @endforeach
								</select>		
					</div>
					
					<script type="text/javascript">
					    $(function () {
					        $('#datetimepicker6').datetimepicker({
					 
					        });
					        $('#datetimepicker7').datetimepicker({
					        	
					            useCurrent: false //Important! See issue #1075
					        });
					        $("#datetimepicker6").on("dp.change", function (e) {
					            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
					        });
					        $("#datetimepicker7").on("dp.change", function (e) {
					            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
					        });
					    });
					</script>  

					<div class='col-md-5'>
				        <div class="form-group">
				        	{!! Form::label('start_date','Select Start Date') !!}
				            <div class='input-group date' id='datetimepicker6'>
				                <input type='text' name="start_date" class="form-control" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>
				    </div>
				    
				    <div class='col-md-5'>
				        <div class="form-group">
				        	{!! Form::label('end_date','Select End Date') !!}
				            <div class='input-group date' id='datetimepicker7'>
				                <input type='text' name="end_date" class="form-control" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>
    				</div>
				

					<div class="form-group" id="x">
					    {!! Form::label('Enter The Location Of Your Event') !!}
					    {!! Form::text('location[]', 
					    				null, 
					      				array('required', 
					         		    'class'=>'form-control', 
					          		    'placeholder'=>'Enter The Location Of Your Event')) !!}
					 <input type="button" class="btn btn-secondary"value="Open to suggestions" onClick="togglePoll(x);">
					
					</div>
					
    				
					<div class="form-group">
					    {!! Form::label('Enter The Number Of Tickets') !!}
					    {!! Form::input('number', 'no_tickets', 
					    				0, 
					      				array('required', 
					         		    'class'=>'form-control')) !!}
					    
					</div>

					<div class='form-group'>
								{!! Form::label('scope', 'Event Scope: ' ) !!}
								{!! Form::select('scope', ['Select a Category', 'Local', 'Regional', 
								'National'], null, ['class'=>'form-control']) !!}
					</div>

					<div class='form-group'>
						{!! Form::label('genre', 'Event Type: ' ) !!}
						{!! Form::select('genre', ['Select a Category', 'Music', 'Sport', 
							'Theatre', 'Convention',
							'Course', 'Conference', 'Seminar', 'Gaming', 'Party', 'Screening', 
							'Tour', 'Other'], null, ['class'=>'form-control']) !!}
					</div>

					<div class='form-group'>
								{!! Form::label('logo', 'Logo: ' ) !!}
								{!! Form::file('image',null, ['class'=>'form-control']) !!}
					</div>

					<div class="form-group">
					    {!! Form::textarea('bio', null, 
					        array('required', 
					              'class'=>'form-control', 
					              'placeholder'=>'Enter a description of the event!')) !!}
					</div>

					<div class="form-group">
					    {!! Form::label('Select your tickets') !!}
					</div>

				
						<table id="dynamic-tickets" class="ticket-table">
						

						</table>
					<input type="button" class="btn btn-secondary"value="Add Ticket" onClick="addTicket('dynamic-tickets');">
						

					<!--Added by joe to handle itinery Items.-->
					<p>Optionally Add specific items to the Itinery</p>
					
					<div class="form-group">
						<div id="dynamicInput">
         				   <!--  Itinerary From divs will go here  -->
         				</div>	 
     					<input type="button" class="btn btn-secondary"value="Add Itinerary Item" onClick="addInput('dynamicInput');">
						
					</div>
					
					<div class="form-group">
						{!! Form::submit('Create Event!', array('class'=>'btn btn-primary')) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">	

	var nextTicket = 1;
	var ticketCounter = 0;
	var itemElement = 1;
	var counter = 1;
	var limit = 3;

	function addInput(divName){
    	if (counter == limit)  {
        	alert("You may only add " + counter + " inputs");
		}
     	else {
        	var newdiv = document.createElement('div');
        	newdiv.setAttribute('id','itinItem'+counter);
       		//counter++;
        	newdiv.innerHTML ="<hr />"+
        				"<label for='itemName"+counter+"'>Name</label>"+
         				"<input type='text' name='item["+itemElement+"]' class='form-control'>"+
         				"<label for='itemDesc"+counter+"'>Description</label>"+
         				"<input type='text' name='item["+(itemElement+1)+"]' class='form-control'>"+
         				"<label for='itemTime"+counter+"'>Time</label>"+
         				"<input type='text' name='item["+(itemElement+2)+"]' class='form-control'>"+
						"<label for='itemTime"+counter+"'>Cost(optional)</label>"+
         				"<input type='text' name='item["+(itemElement+3)+"]' class='form-control'>"+
         				"<label for='itemTime1'>Capacity</label>"+
         				"<input type='text' name='item["+(itemElement+4)+"]' class='form-control'>"+
       					"<input type='checkbox' name='item["+(itemElement+5)+"]' value='true'>Pre-booked?<br>"+
						"<input type='button' class='btn btn-secondary'value='Remove Itinerary Item' onClick='removeInput(itinItem"+counter+");'>";
       		counter++;			
			itemElement+=6;
        	document.getElementById(divName).appendChild(newdiv);      
    	}
 
	}
 function removeInput(e){
 		e.remove();
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
       							'<select name="tickets[]">'+
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
								'<input type="button" step="0.50" class="form-control" value="-" onClick="removeTicket(ticket'+ nextTicket+');" />'+
								
							'</td>';
       	
        document.getElementById(divName).appendChild(newrow);  
        ticketCounter++;
       	nextTicket++;
	}

	function removeTicket(e){
 		e.remove();
 		if(ticketCounter ==1){
 			document.getElementById('tickethead').remove();
 		} 
 		ticketCounter--;
 		console.log("There is now " + ticketCounter + " tickets remaining");
    }
 
    var locationPolled = false;
    var numOfSuggestions = 0;
    var next_ID = 1;

    function togglePoll(e){
    	console.log("add location to poll");
    	if(!locationPolled){
    		locationPolled = true;
    		numOfSuggestions = 1;
    	document.getElementById('x').innerHTML=
    										"<div id='locationSuggestion"+next_ID+"'>"
    										+"<label for='location'>Enter Location Suggestions</label>"
         									+"<input type='text' name='location[]' class='form-control'>"
           									+"</div>"
           									+"<input type='button' id='addButton' class='btn btn-secondary'value='Add Suggestion' onClick='addSuggestion(x);'>"
					 						+"<input type='button' class='btn btn-secondary'value='Remove Poll' onClick='togglePoll(x);'>";
    	}else{
    		locationPolled = false;
    		numOfSuggestions = 0;
    		document.getElementById('x').innerHTML=
    										"<label for='location'>Enter Location</label>"
         									+"<input type='text' name='location[]' class='form-control'>"
              								+"<input type='button' class='btn btn-secondary'value='Open to suggestions' onClick='togglePoll(x);'>";
    	}
    	next_ID++;
	}

    function addSuggestion(num){
    	numOfSuggestions++;
    	var nextSuggestion = document.createElement('div');
    	nextSuggestion.innerHTML="<div id='locationSuggestion"+next_ID+"'>"								
         						+"<input type='text' name='location[]' class='form-control'>"
         						+"<input type='button' class='btn btn-secondary'value='remove Suggestion' onClick='removeSuggestion(locationSuggestion"+next_ID+");'>"
           						+"</div>";         									
           	next_ID++;
    		num.insertBefore(nextSuggestion, addButton);
    }
   	
   	function removeSuggestion(num){
   		if(numOfSuggestions>1){
   			num.remove();
   			numOfSuggestions--;
   		}
   	}   
</script>

@endsection
