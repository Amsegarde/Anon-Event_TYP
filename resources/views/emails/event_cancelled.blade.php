@extends('email')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-body">
					
					<h2>{{ $name }} CANCELLED!</h2>
					<p>
						We regret to infor you that the following event {{ $name }},
						has been cancelled.
					</p>


					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection