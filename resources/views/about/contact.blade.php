@extends('app')

@section('content')
	<div class="row">
		<h1>Contact Anon-Event</h1>

		<ul>
		    @foreach($errors->all() as $error)
		        <li>{{ $error }}</li>
		    @endforeach
		</ul>

		{!! Form::open(array('route' => 'contact_store')) !!}

		<div class="input-field">
		    {!! Form::label('Your Name') !!}
		    {!! Form::text('name', null, 
		        array('required', 
		              'placeholder'=>'Your name')) !!}
		</div>

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