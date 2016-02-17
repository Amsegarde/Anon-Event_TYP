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
								    	<!--look into passing org id along with form even though its not displayed-->
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

					<div class="form-group">
					    {!! Form::label('Enter The Location Of Your Event') !!}
					    {!! Form::text('location', 
					    				null, 
					      				array('required', 
					         		    'class'=>'form-control', 
					          		    'placeholder'=>'Enter The Location Of Your Event')) !!}
					    
					</div>
    				
					<div class="form-group">
					    {!! Form::label('Enter The Number Of Tickets') !!}
					    {!! Form::input('number', 'no_tickets', 
					    				0, 
					      				array('required', 
					         		    'class'=>'form-control')) !!}
					    
					</div>

					<div class="form-group">
					    {!! Form::label('Enter The Price Of A Ticket') !!}
					    {!! Form::input('number', 'price', 
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

					<table class="ticket-table">
						<tr>
							<th>Type</th><th>Price</th>
							
						</tr>
						<tr>
							<td>	
								{!! Form::select('ticket_type[1]', ['Free', 'Paid', "Students", "OAP", 'Early Bird', 'R.S.V.P', 'Custom'], null, ['class'=>'form-control']) !!}
							</td>	
							<td>
								<div class="form-group">
									<input type="number" name="ticket_price[1]" step="0.50" class="form-control" />
								</div>
							</td>
						</tr>
						<tr>
							<td>	
								{!! Form::select('ticket_type[2]', ['Free', 'Paid'], null, ['class'=>'form-control']) !!}
							</td>	
							<td>
								<div class="form-group">
									<input type="number" name="ticket_price[2]" step="0.50" class="form-control" />
								</div>
							</td>
						</tr>
					</table>
					
					<a href="#" title="" class="add-ticket">Add Another Ticket Type</a>

					<script type="text/javascript">
						jQuery(function(){
						    var counter = 1;
						    jQuery('a.add-ticket').click(function(event){
						        event.preventDefault();
							    counter++;
							    var newRow = jQuery('<tr><td><input type="text" name="first_name' +
							    counter + '"/></td><td><input type="number" name="ticket_type' +
							    counter + '"/></td></tr>');
							    jQuery('table.ticket-table').append(newRow);
							});
						});
					</script>
					<!--Added by joe to handle itinery Items.-->
					<p>Optionally Add specific items to the Itinery</p>
					
					<div class="form-group">
						<div id="dynamicInput">
         					<label for="itemName1">Name</label>
         					<input type="text" name="item[1]" class="form-control">
         					<label for="itemDesc1">Description</label>
         					<input type="text" name="item[2]" class="form-control">
         					<label for="itemTime1">Time</label>
         					<input type="text" name="item[3]" class="form-control">
         					<label for="itemTime1">Cost(optional)</label>
         					<input type="text" name="item[4]" class="form-control">
							<label for="itemTime1">Capacity</label>
         					<input type="text" name="item[5]" class="form-control">
         					<input type="checkbox" name="item[6]" value="true">Pre-booked?<br>

         				</div>	 
     					<input type="button" class="btn btn-secondary"value="Add Itinery Item" onClick="addInput('dynamicInput');">
					
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

<script src="/wp-includes/js/addInput.js" language="Javascript" type="text/javascript"></script>
<script type="text/javascript">	
	var itemElement = 7;
	var counter = 1;
	var limit = 3;
	function addInput(divName){
    	if (counter == limit)  {
        	alert("You may only add " + counter + " inputs");
		}
     	else {
        	var newdiv = document.createElement('div');
       		counter++;
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
       					"<input type='checkbox' name='item["+(itemElement+5)+"]' value='true'>Pre-booked?<br>";
			itemElement+=6;
        	document.getElementById(divName).appendChild(newdiv);      
     }
}
</script>

@endsection
