@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Your Tickets</div>

					@if (Auth::guest())
						<p>You must be logged in, in order to view tickets</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else
						<article style="background-color:pink">
							<h2>{{ $event->name }}</h2>
							<h4><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h4>
							<h4>Type: {{ $ticket->type }}</h4>
							<h4>Quantity: {{ $ticket->quantity }}</h4>
							<h5>Date: {{ $event->start_date }} | Ticket No: {{ $ticket->id }}</h5>
							<h5>Location: {{ $event->location }}</h5>

							<div class="visible-print text-center">
							    {!! QrCode::margin(2)->size(165)->generate('Ticket' . $ticket->id . 'Qrcode generator') !!}
							    
							</div>	

							<!-- Modal Trigger -->
							<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Cancel Order</a>

							<!-- Modal Structure -->
							<div id="modal1" class="modal">
						    	<div class="modal-content">
							    	{!! Form::open(array('route' => ['cancel_order', $ticket->id], 'method' => 'delete')) !!}
										{!!  Form::hidden ('ticketID', $ticket->id) !!}

										<div class="row">
											{!! Form::label('Are you sure you want to cancel the order?') !!}
										</div>
										<div class="input-field">
											{!! Form::submit('Confirm Cancelation', array('class'=>'btn')) !!}
										</div>

									{!! Form::close() !!}
							    </div>
							</div>

							<div class="input-field">
								{!! Form::submit('Print Tickets', array('class'=>'btn btn-primary')) !!}
							</div>

							<div class="input-field">
								{!! Form::submit('Contact Organisation', array('class'=>'btn btn-primary')) !!}
							</div>

						</article>					  

					@endif

					<script type="text/javascript">
						// For the Rich Text Editor
						// CKEDITOR.replace( 'bio' );
						
						$(document).ready(function(){
							// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
							$('.modal-trigger').leanModal();
						});

						$(document).ready(function(){
							$('ul.tabs').tabs('select_tab', 'tab_id');
						});

					</script>

			</div>
		</div>
	</div>
</div>

@endsection