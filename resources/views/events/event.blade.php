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

					{!! Form::open(array('url' => 'events/' . $event->id . '/ticket/confirm', 'class' => 'form')) !!}
					{!!  Form::hidden('eventID', $event->id) !!}
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
									<div class='form-group'>
										{!! Form::select('quantity', [
														'1', 
														'2', 
														'3',
														'4',
														'5',
														'6'], 
														null, 
														['class'=>'form-control']) !!}
					</div>

								</td>
								<td>
									@if (($event->avail_tickets) === 0 )
										SOLD OUT
									@else
										<div class="form-group">
											{!! Form::submit('Get Tickets', array('class'=>'btn btn-primary')) !!}
										</div> : {{ $event->avail_tickets }} Remaining
									@endif
									
								</td>
							</tr>
						</table>
					{!! Form::close() !!}

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