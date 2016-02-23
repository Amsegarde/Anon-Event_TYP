@extends('app')

@section('content')

<div class="row">
	@if (Auth::guest())
		<p>You must be logged in, in order to create an organisation</p>
		<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
	@else

		@if ($errors->any())
			<ul class='alert alert-danger'>
				@foreach ($errors->all() as $error)
					<li>{!! $error !!}</li>
				@endforeach
			</ul>
		@endif

		<!-- This is the create organisation form -->
		{!! Form::open(array('url'=>'organisation','method'=>'POST', 'files'=>true, 'class'=>'col s12')) !!}
			<div class="row">
				<!-- Bio Form input -->
				<div class="input-field">
					{!! Form::label('name', 'Organisation Name: ') !!}
					{!! Form::text('name', null) !!}
				</div>

				<!-- Bio Form input -->
				<div class="input-field">
					<textarea id="bio" name="bio" class="materialize-textarea" length="500"></textarea>
					<label for="bio">Biography</label>
				</div>

				<div class='input-fields'>
					{!! Form::select('scope', ['Scope','None', 'Local', 'Regional', 'National'], null) !!}
				</div>

				<div class='file-field input-field '>
					<div class="btn indigo lighten-1">
						<span>Upload logo</span>
						<input name="image" type="file">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>
				
				<!-- Submit Form input -->
				<div class='input-field'>
					{!! Form::submit('Add Organisation', ['class'=>'btn indigo lighten-1']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	@endif
</div>

<script>
	$(document).ready(function() {
		$('select').material_select();
	});
</script>

@endsection
