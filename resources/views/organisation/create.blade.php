@extends('app')

@section('content')

	@if (Auth::guest())
		<p>You must be logged in, in order to create an organisation</p>
		<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
	@else

		{!! Form::open(['url' => 'organisation']) !!}
			<!-- Bio Form input -->
			<div class="form-group">

				{!! Form::label('name', 'Organisation Name: ') !!}
				{!! Form::text('name', null, ['class' => 'form-control']) !!}
			</div>

			<!-- Bio Form input -->
			<div class="form-group">
				{!! Form::label('bio', 'Biography: ') !!}
				{!! Form::textarea('bio', null, ['class' => 'form-control']) !!}
			</div>

			<div class='form-group'>
				{!! Form::label('scope', 'Scope: ' ) !!}
				{!! Form::select('scope', ['Select a Category', 'Local', 'Regional', 'National'], null, ['class'=>'form-control']) !!}
			</div>

			<div class='form-group'>
				{!! Form::label('logo', 'Logo: ' ) !!}
				{!! Form::text('logo', 'upload logo', ['class'=>'form-control']) !!}
			</div>

			<!-- Submit Form input -->
			<div class='form-group'>
				{!! Form::submit('Add Organisation', ['class' => 'btn btn-primary form-control']) !!}
			</div>



		{!! Form::close() !!}
	@endif

@endsection
