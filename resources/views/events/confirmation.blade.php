@extends('app')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					@if (Auth::guest())
						<p>You must have an account in order to get tickets.</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else

						@if ($totalQuantity > $event->avail_tickets)
							<h4>Sorry, that amount of tickets is not available</h4>
							<p>Tickets Remaining: {{ $event->avail_tickets }}</p>
							<p>You Selected: {{ $totalQuantity }}</p>
							<a href="{{ url('/events/'.$event->id) }}">Return</a>

						@elseif ($totalQuantity === 0)
							<h4>Sorry you have not selected any tickets</h4>
							<a href="{{ url('/events/'.$event->id) }}">Return</a>
							
						@else
							{!! Form::open(array('route' => 'store_tickets', 'class' => 'form')) !!}
								{!! Form::hidden('eventID', $event->id) !!}
								{!! Form::hidden('request', $request) !!}
								{!! Form::hidden('request', $tickets) !!}
								{!!	Form::hidden('totalQuantity', $totalQuantity) !!}
								{!!	Form::hidden('totalPrice', $totalPrice) !!}

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
						
							@if($totalPrice == 0)			
								{!! Form::submit('Confirm Free', array('class'=>'btn btn-primary')) !!}
								{!! Form::close() !!}
							@else
					{!! Form::close() !!}

				<div class="row">
				    {!! Form::open(['url' => route('order-post'), 'method' => 'post' ,'data-parsley-validate', 'id' => 'payment-form']) !!}
						{!! Form::hidden('eventID', $event->id) !!}
						{!! Form::hidden('request', $request) !!}
						{!! Form::hidden('request', $tickets) !!}
						{!!	Form::hidden('totalQuantity', $totalQuantity) !!}
						{!!	Form::hidden('totalPrice', $totalPrice) !!}

					<div class="row col s6" id="first-name-group">
						{!! Form::label('firstName', 'First Name:') !!}
						{!! Form::text('first_name', Auth::user()->firstname, [
							'required'                      => 'required',
							'data-parsley-required-message' => 'First name is required',
							'data-parsley-trigger'          => 'change focusout',
							'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
							'data-parsley-minlength'        => '2',
							'data-parsley-maxlength'        => '32',
							'data-parsley-class-handler'    => '#first-name-group'
							]) !!}
					</div>

					<div class="row col s6" id="last-name-group">
						{!! Form::label('lastName', 'Last Name:') !!}
						{!! Form::text('last_name', Auth::user()->lastname, [
							'required'                      => 'required',
							'data-parsley-required-message' => 'Last name is required',
							'data-parsley-trigger'          => 'change focusout',
							'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
							'data-parsley-minlength'        => '2',
							'data-parsley-maxlength'        => '32',
							'data-parsley-class-handler'    => '#last-name-group'
							]) !!}
					</div>

					<div class="row col s12" id="email-group">
						{!! Form::label('email', 'Email address:') !!}
						{!! Form::email('email', Auth::user()->email, [
							'placeholder'                   => 'email@example.com',
							'required'                      => 'required',
							'data-parsley-required-message' => 'Email name is required',
							'data-parsley-trigger'          => 'change focusout',
							'data-parsley-class-handler'    => '#email-group'
							]) !!}
					</div>

					<div class="row col s8" id="cc-group">
						{!! Form::label(null, 'Credit card number:') !!}
						{!! Form::text(null, null, [
							'required'                      => 'required',
							'data-stripe'                   => 'number',
							'data-parsley-type'             => 'number',
							'maxlength'                     => '16',
							'data-parsley-trigger'          => 'change focusout',
							'data-parsley-class-handler'    => '#cc-group'
							]) !!}
					</div>

					<div class="row col s4" id="ccv-group">
						{!! Form::label(null, 'Card Validation Code (3 or 4 digit number):') !!}
						{!! Form::text(null, null, [
							'required'                      => 'required',
							'data-stripe'                   => 'cvc',
							'data-parsley-type'             => 'number',
							'data-parsley-trigger'          => 'change focusout',
							'maxlength'                     => '4',
							'data-parsley-class-handler'    => '#ccv-group'
							]) !!}
					</div>
						
					<div class="row col s6" id="exp-m-group">
						{!! Form::label(null, 'Ex. Month') !!}
						{!! Form::selectMonth(null, null, [
							'required'              => 'required',
							'data-stripe'           => 'exp-month'
							], '%m') !!}
					</div>
					<div class="row col s6" id="exp-y-group">
						{!! Form::label(null, 'Ex. Year') !!}
						{!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
							'required'          => 'required',
							'data-stripe'       => 'exp-year'
							]) !!}
					</div>

					<div class="row col s12">
						{!! Form::submit('Place order!', ['class' => 'btn btn-primary btn-order', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
	   				</div>

					<div class="row col s12">
						<span class="payment-errors" style="color: red;margin-top:10px;"></span>
					</div>

					{{-- Show $request errors after back-end validation --}}
					<div class="row col s12">
						@if($errors->has())
							<div class="alert alert-danger fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4>The following errors occurred</h4>
								<ul>
									@foreach($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
					</div>
					{!! Form::close() !!}
					@endif
				</div>
			@endif
		@endif
	</div>
@endsection