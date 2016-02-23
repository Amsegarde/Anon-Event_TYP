@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You received a message from Anon-Event

					<p>
						Name: {{ $name }}
					</p>

					<p>
						{{ $email }}
					</p>

					<p>
						{{ $user_message }}
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
