@extends('app')

@section('content')
	<div class="row">
<<<<<<< HEAD
		<h1>Contact Anon-Event</h1>
=======
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
>>>>>>> 72844a56eed4ceaf37b47e151388abade5e7e6b2

		<ul>
		    @foreach($errors->all() as $error)
		        <li>{{ $error }}</li>
		    @endforeach
		</ul>

<<<<<<< HEAD
		{!! Form::open(array('route' => 'contact_store')) !!}

		<div class="input-field">
		    {!! Form::label('Your Name') !!}
		    {!! Form::text('name', null, 
		        array('required', 
		              'placeholder'=>'Your name')) !!}
		</div>
=======
					<ul>
					    @foreach($errors->all() as $error)
					        <li>{{ $error }}</li>
					    @endforeach
					</ul>
					<div class="row">
						<p>
							<?php 
								echo Session::get('message');
							?>
						</p>
					</div>
					{!! Form::open(array('route' => 'contact_store', 'class' => 'form')) !!}

					<div class="form-group">
					    {!! Form::label('Your Name') !!}
					    {!! Form::text('name', null, 
					        array('required', 
					              'class'=>'form-control', 
					              'placeholder'=>'Your name')) !!}
					</div>
>>>>>>> 72844a56eed4ceaf37b47e151388abade5e7e6b2

		<div class="input-field">
		    {!! Form::label('Your E-mail Address') !!}
		    {!! Form::text('email', null, 
		        array('required', 
		              'placeholder'=>'Your e-mail address')) !!}
		</div>

		<div class="input-field">
		    {!! Form::label('Your Message') !!}
		    {!! Form::textarea('message', null, 
		        array('required', 
		        	'class' => 'materialize-textarea',
		              'placeholder'=>'Your message')) !!}
		</div>

		<div class="input-field">
		    {!! Form::submit('Contact Us!', 
		      array('class'=>'btn')) !!}
		</div>
		{!! Form::close() !!}
	</div>
@endsection