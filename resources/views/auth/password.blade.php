@extends('app')

@section('content')
<div class="container">

	<h5>Password Reset</h3>

	<div class="row">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif
		{!! Form::open(array('url'=>'/auth/register','method'=>'POST', 'class'=>'col s12')) !!}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="input-field col s12">
					{!! Form::label('email', 'E-mail Address', ["class"=>"validate"]) !!}
					{!! Form::email('email', null) !!}
				</div>

				<div class="input-field col s12">
					{!! Form::submit('Send Password Reset Link', ['class'=>'btn indigo lighten-1']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection