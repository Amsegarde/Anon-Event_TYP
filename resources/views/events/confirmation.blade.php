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
						{!! Form::open(array('url' => 'tickets', 'class' => 'form')) !!}
							{!! Form::hidden('eventID', $event->id) !!}
							{!! Form::hidden('request', $request) !!}
							{!! Form::hidden('request', $tickets) !!}
							{!!	Form::hidden('totalQuantity', $totalQuantity) !!}

							<h2>{{ $event->name }}</h2>
							<p>Date: {{ $event->start_date }}</p>


							<table>
								<tr>
									<th>Type</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
								</tr>

								@for ($i = 0; $i < count($totals); $i++)
									@if ($quantity[$i] > 0)

										{!!	Form::hidden('type[]', $type[$i]) !!}
										{!!	Form::hidden('price[]', $price[$i]) !!}
										{!!	Form::hidden('quantity[]', $quantity[$i]) !!}

										<tr>
											<td>{{ $type[$i] }}</td>
											<td>{{ $price[$i] }}</td>
											<td>{{ $quantity[$i] }}</td>
											<td>{{ $totals[$i] }}</td>
										</tr>
									@endif
								@endfor

								<tr><td></td><td>Total:</td><td>{{ $totalQuantity }}</td><td>{{ $totalPrice }}</td></tr>
							</table>
						
			
							{!! Form::submit('Confirm', array('class'=>'btn btn-primary')) !!}
				
						{!! Form::close() !!}
					@endif

				</div>
			</div>
		</div>
	</div>
</div>
@endsection