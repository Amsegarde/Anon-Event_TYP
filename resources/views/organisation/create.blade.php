@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>


					@if (Auth::guest())
						<p>You must be logged in, in order to create an organisation</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else

						{!! Form::open(array('url'=>'organisation','method'=>'POST', 'files'=>true)) !!}
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
								{!! Form::file('image',null, ['class'=>'form-control']) !!}
							</div>

							<!-- Submit Form input -->
							<div class='form-group'>
								{!! Form::submit('Add Organisation', ['class' => 'btn btn-primary form-control']) !!}
							</div>



						{!! Form::close() !!}
					@endif

					</div>
		</div>
	</div>
</div>

@endsection
