@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					<h1>{!! $event->name !!}</h1>
					<h4><a href="{{ url('/organisation/' . $org->id) }}">{!! $org->name !!}</a></h4>
					<hr />

				
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
									<select name="quantity" class="form-control">
										<option value="0">1 <?php $event->quantity = 1 ?> </option>	
										<option value="1">2 <?php  $event->quantity = 2 ?> </option>
									    <option value="2">3 <?php  $event->quantity = 2 ?> </option>		  
									</select>

								</td>
								<td>
									@if (($event->avail_tickets) === 0 )
										SOLD OUT
									@else
										<button><a href="{{ url('/events/' . $event->id . '/ticket') }}">Get Ticket</a></button> : {{ $event->avail_tickets }} Remaining
									@endif
									
								</td>
							</tr>
						</table>
				

					<hr />

					<h4>Description</h4>
					<p>{{ $event->bio }}</p>

					<h4>Where</h4>
					<p>{{ $event->Location }}</p>

					<h4>When</h4>
					<p>{{ $event->start_date }}</p>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection