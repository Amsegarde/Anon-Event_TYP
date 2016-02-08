@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					<h1>{!! $org->name !!}</h1>

					<p>{!! $org->bio !!}</p>

					<img src="../images/organisations/{!! $org->id !!}">
					<p>Display logo!</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
