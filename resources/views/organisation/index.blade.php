@extends('app')

@section('content')
	
				

		@foreach ($organisations as $organisation) 
			<div class="col s5 offset-s1">
				<a href="{{ url('organisation/' . $organisation->id) }}">
					{{-- <div class="card small"> --}}	
						
							<img class="responsive-img" src="{{ asset('images/organisations/').'/'. $organisation->id.'.'.$organisation->image }}">

								<h3>{{ $organisation->name }}</h3>		

					{{-- </div> --}}
				</a>
			</div>
		@endforeach



@endsection
