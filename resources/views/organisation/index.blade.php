@extends('app')

@section('content')
	<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">		
				
	<h2>My Organisations</h2>

	@foreach ($organisations as $organisation) 
		<article >
			<a href="{{ url('/organisation/' . $organisation->id) }}">
				<h2>{{ $organisation->name }}</h2>		
			</a>
		</article>
	@endforeach

	</div>
		</div>
	</div>
</div>

@endsection
