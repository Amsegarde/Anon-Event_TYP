@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					<h1>{!! $event->name !!}</h1>

					<p>{!! $event->bio !!}</p>

					<table>
						<tr>
							<th>Ticket Type</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Get Ticket</th>
						</tr>
						
						<tr>
							<td>Free</td>
							<td>0</td>
							<td>
								<!--<select name="quantity" class="form-control">
									<option value="0">1 {{ $event->quantity === 1 }}</option>	
									<option value="1">2 {{ $event->quantity === 2 }}</option>
								    <option value="2">3</option>

								  
								</select>	-->
							</td>
							<td>
								@if (($event->avail_tickets) === 0 )
									SOLD OUT
								@else
									<button><a href=" {{ url('/events/' . $event->id . '/ticket') }}">Get Ticket</a></button> : {{ $event->avail_tickets }} Remaining
								@endif
								
							</td>
						</tr>
						{!! $event->id !!}
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection