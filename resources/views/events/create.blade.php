@extends('app')

@section('content')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

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

<script src="/wp-includes/js/addInput.js" language="Javascript" type="text/javascript"></script>
<script type="text/javascript">	
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
    	counter--;
    	//console.log(document.getElementById(e));
    	//.remove(this);
    }
</script>

@endsection
