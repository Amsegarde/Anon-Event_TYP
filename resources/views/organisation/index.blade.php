@extends('app')

@section('content')
	
				
<div class="row">
		@foreach ($organisations as $organisation) 
			<a href="{{ url('organisation/' . $organisation->id) }}">
				
					<div class="col s3">	
						<div id="ho" class="card" >
							<div class="card-content">
								<h4  align="middle">{{ $organisation->name }}</h4>	
							</div>
						</div>	
					</div>
				
			</a>
		@endforeach

</div>

@endsection
