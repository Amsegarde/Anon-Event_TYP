@extends('app')

@section('content')
	
				
<div class="row">
		@foreach ($organisations as $organisation) 
			<a href="{{ url('organisation/' . $organisation->id) }}">
				
					<div class="col s3">	
						<div class="card">
							<div class="card-content">
								<div  class="card-image" id="blur">
									<img class="responsive-img left" src="{{ asset('images/organisations/').'/'. $organisation->id.'.'.$organisation->image }}">
								</div>
								<h4 align="middle">{{ $organisation->name }}</h4>	
							</div>
						</div>	
					</div>
				
			</a>
		@endforeach

</div>

@endsection
