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
							<td>1</td>
							<td><button><a href="/events/{!! $event->id !!}/ticket">Get Ticket</a></button> : {{ $event->avail_tickets }} Remaining</td>
						</tr>
						{!! $event->id !!}
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
