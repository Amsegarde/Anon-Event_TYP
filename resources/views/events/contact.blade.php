@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<h1>Contact Attendees</h1>

					<ul>
					    @foreach($errors->all() as $error)
					        <li>{{ $error }}</li>
					    @endforeach
					</ul>

					{!! Form::open(array('route' => 'contact_attendees', 'class' => 'form')) !!}
						{!! Form::hidden('eventID', $organises->event_id) !!}
						{!! Form::hidden('organisationID', $organises->organisation_id) !!}

						<div class="form-group">
						    {!! Form::label('title') !!}
						    {!! Form::text('title', null, 
						        array('required', 
						              'class'=>'form-control', 
						              'placeholder'=>'Your name')) !!}
						</div>

						<div class="form-group">
						    {!! Form::label('Message') !!}
						    {!! Form::textarea('message', null, 
						        array('required', 
						              'class'=>'form-control', 
						              'placeholder'=>'message')) !!}
						</div>

						<div class="form-group">
						    {!! Form::submit('Send!', 
						      array('class'=>'btn btn-primary')) !!}
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection