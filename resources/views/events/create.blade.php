@extends('app')

@section('content')
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
					

					<div class="form-group">
					    {!! Form::label('Describe the Event') !!}
					    {!! Form::textarea('bio', null, 
					        array('required', 
					              'class'=>'form-control', 
					              'placeholder'=>'Enter a description of the event!')) !!}
					</div>

					<div class="form-group">
					    {!! Form::submit('Create Event!', 
					      array('class'=>'btn btn-primary')) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
