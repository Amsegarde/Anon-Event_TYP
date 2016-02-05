@extends('app')

@section('content')

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
			{!! Form::label('logo', 'Logo: ' ) !!}
			{!! Form::text('logo', 'upload logo', ['class'=>'form-control']) !!}
		</div>

		<!-- Submit Form input -->
		<div class='form-group'>
			{!! Form::submit('Add Organisation', ['class' => 'btn btn-primary form-control']) !!}
		</div>



	{!! Form::close() !!}

@endsection
