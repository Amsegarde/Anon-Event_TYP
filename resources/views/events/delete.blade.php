@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<h2>Warning: Are you sure you want to delete the event?</h2>
				<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Delete Event</a>
			</div>

			<!-- Modal Structure -->
			<div id="modal1" class="modal">
		    	<div class="modal-content">
		    		<h4>Confirm Delete Event</h4>
			    	{!! Form::open(array('route' => 'cancel_event', 'method' => 'delete')) !!}
			    		{!! Form::hidden('eventID', $eventID) !!}
			    		
						<div class="row">
							{!! Form::label('There\'s no turning back once you confirm?') !!}
						</div>
						<div class="input-field">
							{!! Form::submit('Confirm', array('class'=>'btn')) !!}
						</div>

					{!! Form::close() !!}
			    </div>
			</div>

		</div>
	</div>
</div>
@endsection