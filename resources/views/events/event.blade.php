@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<h1>{!! $eventDetails['name'] !!}</h1>
					<h3>From: {!! $eventDetails['start_date'] !!} until {!! $eventDetails['end_date'] !!}</h3>
					<p>This is an event page for event number {!! $eventDetails['id'] !!} </p>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
