@extends('app')

@section('content')

	<div class="row">

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

		{!! Form::open(array('url'=>'/auth/login','method'=>'POST', 'class'=>'col s12')) !!}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="input-field">
					{!! Form::label('email', 'E-mail Address') !!}
					{!! Form::email('email', null) !!}
				</div>

				<div class="input-field">
					{!! Form::label('password', 'Password') !!}
					{!! Form::password('password', null) !!}
				</div>

				<div class="input-field">
					<p>
						<input type="checkbox" id="remember" namd="remember" />
						<label for="remember">Remember Me</label>
					</p>
				</div>

				<div class="input-field">
					{!! Form::submit('Login', ['class'=>'btn indigo lighten-1']) !!}
				</div>

				<div class="input-field">
					<a href="{{ url('/password/email') }}">Forgot Your Password?</a>
				</div>
			</div>
		{!! Form::close() !!}
	</div>

@endsection
