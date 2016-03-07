@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				
				<div class="row">
					<p><?php 
						echo Session::get('message');
						?>
					</p>
				</div>
				
				@if (Auth::guest())
					<p>You must be logged in, in order to view tickets</p>
					<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
				@else
					<h5 class="title col s12">Account Settings</h5>
					
					<ul>
					    @foreach($errors->all() as $error)
					        <li>{{ $error }}</li>
					    @endforeach
					</ul>

					<div class="row">
						<div class="input-field col s4">
							{!! Form::label('Email') !!}
							{!! Form::text('email', 
											$user->email, 
											array('readonly' => true
											)) !!}
							<div class="row">
								<a class="waves-effect waves-light btn modal-trigger" href="#modal2">Change Email</a>
							</div>
						</div>	
					</div>

					<div id="modal2" class="modal">
				    	<div class="modal-content">
					    	<h4>Change Email</h4>

							
							{!! Form::open(array('route' => 'update_email', 'class' => 'form')) !!}
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								{!! Form::hidden('userEmail', $user->email) !!}
								{!! Form::hidden('userID', $user->id) !!}

								<div class="form-group">
								    {!! Form::label('New Email') !!}
								    {!! Form::text('email', null, 
								        array('required', 
								              'class'=>'form-control', 
								              'placeholder'=>'Email')) !!}
								</div>

								<div class="input-field">
									{!! Form::label('password', 'Password') !!}
									{!! Form::password('password', null) !!}
								</div>

								<div class="form-group">
								    {!! Form::submit('Update', 
								      array('class'=>'btn btn-primary')) !!}
								      <a href="{{ url('users/' . $user->id . '/account') }}">Cancel</a>
								</div>

							{!! Form::close() !!}
					    </div>
					</div>

					<div class="row">
						{!! Form::open(array('route' => 'update_details', 'class' => 'form')) !!}
							<div class="row">
							{!! Form::hidden('userID', $user->id) !!}	

								<div class="input-field col s5">
									{!! Form::label('First Name') !!}
									{!! Form::text('firstname', 
													$user->firstname) !!}
								</div>

								<div class="input-field col s5">
									{!! Form::label('Last Name') !!}
									{!! Form::text('lastname', 
													$user->lastname) !!}
								</div>
															
								<!-- Submit Button -->
								<div class="input-field col s12">
									{!! Form::submit('Update Details!', array('class'=>'btn')) !!} 
								</div>
							</div>
						{!! Form::close() !!}
					</div>

					<script type="text/javascript">
							// For the Rich Text Editor
							// CKEDITOR.replace( 'bio' );
							
							$(document).ready(function(){
								// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
								$('.modal-trigger').leanModal();
							});

							$(document).ready(function(){
								$('ul.tabs').tabs('select_tab', 'tab_id');
							});

						</script>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection