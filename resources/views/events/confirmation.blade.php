@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					@if (Auth::guest())
						<p>You must have an account in order to get tickets.</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else
						<h3>Confirm purchase</h3>
						{!! Form::open(array('url' => 'tickets', 'class' => 'form')) !!}
						{!!  Form::hidden('eventID', $event->id) !!}
						{!!  Form::hidden('request', $request) !!}
						<h2>{{ $event->name }}</h2>
						@for ($i = 0; $i < count($totals); $i++)
								<article id="confirmation">
									
									<p>Type: {{ $type[$i] }}</p>
									<p>Quantity: {{ $quantity[$i] }}</p>
									<p>Subtotal: {{  $totals[$i] }}</p>
									<p>Date: {{ $event->start_date }}</p>

								</article>
						@endfor

							<div class="form-group">
								{!! Form::submit('Confirm', array('class'=>'btn btn-primary')) !!}
							</div>
						{!! Form::close() !!}
					@endif

				</div>
			</div>
		</div>
	</div>
</div>
@endsection