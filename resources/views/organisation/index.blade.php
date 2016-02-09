@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Organisations</div>


					@foreach ($organisations as $organisation) 
							<article >
								<h2>{{ $organisation->name }}</h2>

								
							</article>


					@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
