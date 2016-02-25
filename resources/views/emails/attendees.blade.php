@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">


				<div class="panel-body">
					You received a message from Anon-Event

					<p>
				    	{{ $title }}
					</p>

					<p>
						{{ $message }}
					</p>



		</div>
	</div>
</div>
@endsection