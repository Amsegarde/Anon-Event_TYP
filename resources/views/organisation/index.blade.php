@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">		
				
					<h2>My Organisations</h2>

					<div class="col s9">
					@foreach ($organisations as $organisation) 
						<div class="card-image left" id="browse_card">
							<a href="{{ url('organisation/' . $organisation->id) }}">
								<article >
									<img class="responsive-img" src="{{ asset('images/organisations/').'/'. $organisation->id.'.'.$organisation->image }}">
										<h3>{{ $organisation->name }}</h3>		
								</article>
							</a>
						</div>
					@endforeach
				</div>

			</div>
		</div>
	</div>
</div>


@endsection
