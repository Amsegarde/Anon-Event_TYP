@extends('app')

@section('content')


	<div class="row">
		<h5>Register</h5>
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="row">
			<p><?php 
				echo Session::get('message');
				?>
			</p>
		</div>

		{!! Form::open(array('url'=>'/auth/register','method'=>'POST', 'class'=>'col s12')) !!}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="input-field col s6">
					{!! Form::label('firstname', 'Firstname', ["class"=>"validate"]) !!}
					{!! Form::text('firstname', null) !!}
				</div>
				
				<div class="input-field col s12">
					{!! Form::label('email', 'E-mail Address', ["class"=>"validate"]) !!}
					{!! Form::email('email', null) !!}
				</div>

				<div class="input-field col s12">
					{!! Form::label('password', 'Password', ["class"=>"validate"]) !!}
					{!! Form::password('password', null) !!}
				</div>

				<div class="input-field col s12">
					{!! Form::label('password_confirmation', 'Confirm Password', ["class"=>"validate"]) !!}
					{!! Form::password('password_confirmation', null) !!}
				</div>

				<div class="input-field col s12">
					{!! Form::submit('Register', ['class'=>'btn indigo lighten-1']) !!}
				</div>
			</div>
		{!! Form:: close() !!}

		<div class="row">
			<p>Already have an account? <a href="{{ url('/auth/login') }}">Login Here!</a></p>
		</div>
	</div>

	
@endsection
