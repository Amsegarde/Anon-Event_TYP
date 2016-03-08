@extends('app')

@section('content')
	<div class="row">
		<p style="color:red;"><? php echo Session::get('message'); ?></p>
	</div>

	<div class="info-block">
		<h1>{!! $org->name !!}</h1>
		
		<p>{!! $org->bio !!}</p>

		<img style="max-width:500px; max-height:500px;" src="{{ asset('images/organisations/').'/'.$org->id.'.'.$org->image }}">
	</div>	
	@if  (Auth::guest())

	@elseif ($isAdmin === true)
		<div class="btn-block">
			<p><a id="btn-width" class="waves-effect waves-light btn modal-trigger" href="#modal1">Contact Followers</a></p>
			<p><a id="btn-width" class="waves-effect waves-light btn modal-trigger" href="#modal2">Delete Organisation</a></p>
			<p><a id="btn-width" class="waves-effect waves-light btn modal-trigger" href="#modal3">Update Details</a></p>
			<p><a id="btn-width" class="waves-effect waves-light btn modal-trigger" href="#modal4">Admins</a></p>
		</div>



		<!-- CONTACT FOLLOWERS -->
		<div id="modal1" class="modal">
	    	<div class="modal-content">
		    	<h4>Contact Followers</h4>

				<ul>
				    @foreach($errors->all() as $error)
				        <li>{{ $error }}</li>
				    @endforeach
				</ul>

				{!! Form::open(array('route' => 'contact_followers', 'class' => 'form')) !!}
					{!! Form::hidden('organisationID', $org->id) !!}
					
					<div class="form-group">
					    {!! Form::label('title') !!}
					    {!! Form::text('title', null, 
					        array('required', 'placeholder'=>'Your name')) !!}
					</div>

					<div class="form-group">
					    {!! Form::label('Message') !!}
					    {!! Form::textarea('message', null, 
					        array('required', 'placeholder'=>'message', 'class' => 'materialize-textarea', 'length' => '500')) !!}
					</div>

					<div class="form-group">
					    {!! Form::submit('Send', 
					      array('class'=>'btn btn-primary')) !!}
					      <a href="">Cancel</a>
					</div>

				{!! Form::close() !!}
		    </div>
		</div><!-- END CONTACT FOLLOWERS DIV -->


		<!-- DELETE ORGANISATION DIV -->
		<div id="modal2" class="modal">
	    	<div class="modal-content">
		    	{!! Form::open(array('method' => 'delete')) !!}
					

					<div class="row">
						{!! Form::label('Are you sure you want to delete the event?') !!}
					</div>
					<div class="input-field">
						{!! Form::submit('Confirm Deletion', array('class'=>'btn')) !!}
					</div>

				{!! Form::close() !!}
		    </div>
		</div><!-- END DELETE ORGANISATION DIV -->

		<!-- UPDATE DETAILS -->
		<div id="modal3" class="modal">
	    	<div class="modal-content">
				{!! Form::open(array('route' => 'update_organisation', 'class' => 'form', 'files' => true)) !!}
					{!! Form::hidden('organisationID', $org->id) !!}

					<div class="row">
						{!! Form::hidden('userID', $org->id) !!}	
							<div class="row">
								<div class="input-field col s5">
									{!! Form::label('Name') !!}
									{!! Form::text('name', 
													$org->name) !!}
								</div>
							</div>	
							<div class="row">
								<div class="input-field col s9">
									{!! Form::label('Biograpahy') !!}
									{!! Form::textarea('orgBio', 
													$org->bio, array('class' => 'materialize-textarea', 'length' => '500')) !!}
								</div>
							</div>
							<div class="row"> 
								<div class='file-field input-field '>
									<div class="btn">
										<span>Upload logo</span>
										<input name="image" type="file">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>
							</div>
														
							<!-- Submit Button -->
							<div class="input-field col s12">
								{!! Form::submit('Update!', array('class'=>'btn')) !!} 
								<a href="">Cancel</a>
							</div>
						{!! Form::close() !!}
					</div>
			</div>
		</div><!-- END UPDATE DETAILS DIV -->

		<!-- ADD ADMIN -->
		<div id="modal4" class="modal">
	    	<div class="modal-content">
		    	<h4>Add a new admin for {{ $org->name }}</h4>

				
				{!! Form::open(array('route' => 'add_admin', 'class' => 'form')) !!}
					{!! Form::hidden('organisationID', $org->id) !!}
					<div class="form-group">
					    {!! Form::label('Enter User Email') !!}
					    {!! Form::text('email', null, 
					        array('required', 
					              'class'=>'form-control', 
					              'placeholder'=>'Email')) !!}
					</div>

					<div class="form-group">
					    {!! Form::submit('Add', 
					      array('class'=>'btn btn-primary')) !!}
					      <a href="">Cancel</a>
					</div>

				{!! Form::close() !!}
		    </div>
		</div><!-- END ADD ADMIN DIV -->
	

	@elseif ($hasFavourited === true) 
		<div class="fav-block">
			<a class="waves-effect waves-light btn modal-trigger" href="{{ url('/organisation/' . $org->id . '/unfavourite') }}">UnFavourite</a>
		</div>
	@else
		<div class="fav-block">
			<a class="waves-effect waves-light btn modal-trigger" href="{{ url('/organisation/' . $org->id . '/favourite') }}">Favourite</a>
		</div>
	@endif

	<div class="col s9">
		@foreach ($events as $event)
		<a href="{{ url('events/' . $event->id) }}">
			<div class="card small" id="browse">
				<div class="card-image left" id="browse_card">
					<img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}">
				</div>
				<div class="right-content">
					<div class="card-content">
						<p>Date: {{ $event->start_date }}</p>
						<p>Location: {{ $event->location }}</p>
						<span class="card-title">{{ $event->name }}</span>
					</div>
					<div class="card-action">
						<a href="{{ url('/events/'.$event->id) }}">Get Tickets</a>
					</div>
				</div>
			</div>
		</a>
		@endforeach
	</div>


					

@endsection
