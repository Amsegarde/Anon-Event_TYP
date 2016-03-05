@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

					@if (Auth::guest())
						<p>You must be logged in, in order to view tickets</p>
						<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
					@else
						<article style="border: 1px solid black;">
							<h2>{{ $event->name }}</h2>
							<h4><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h4>
							<h4>Type: {{ $ticket->type }}</h4>
							<h4>Quantity: {{ $ticket->quantity }}</h4>
							<h5>Date: {{ $event->start_date }} | Order No: {{ $ticket->order_number }}</h5>
							<h5>Location: {{ $event->location }}</h5>

							<div class="visible-print text-center">
							    {!! QrCode::margin(1)->size(165)->generate('Event Name: ' . $event->name . ' | Date ' . $event->date . ' | Location: ' . $event->location . ' | Order Number: ' . $ticket->order_nunber . ' | Qrcode generator') !!}
							    
							</div>	

							<!-- Modal Trigger -->
							<p>
								<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Cancel Order</a>
								<a class="waves-effect waves-light btn modal-trigger" href="#modal2">Contact Organisation</a>
								<a class="waves-effect waves-light btn modal-trigger" href="{{ url('/tickets/' . $ticket->id . '/print') }}">Print Tickets</a>
							</p>

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


							<!-- CONTACT ORGANISATION FROM -->
							<div id="modal2" class="modal">
						    	<div class="modal-content">
							    	<h4>Contact Organisation</h4>

									<ul>
									    @foreach($errors->all() as $error)
									        <li>{{ $error }}</li>
									    @endforeach
									</ul>

									{!! Form::open(array('route' => 'contact_organisation', 'class' => 'form')) !!}
										{!! Form::hidden('organisationID', $organisation->id) !!}
										{!! Form::hidden('ticketID', $ticket->id) !!}
										
										<div class="form-group">
										    {!! Form::label('title') !!}
										    {!! Form::text('title', null, 
										        array('required', 
										              'class'=>'form-control', 
										              'placeholder'=>'Your name')) !!}
										</div>

										<div class="form-group">
										    {!! Form::label('Message') !!}
										    {!! Form::textarea('message', null, 
										        array('required', 
										              'class'=>'form-control', 
										              'placeholder'=>'message')) !!}
										</div>

										<div class="form-group">
										    {!! Form::submit('Send', 
										      array('class'=>'btn btn-primary')) !!}
										      <a href="">Cancel</a>
										</div>

									{!! Form::close() !!}
						    	</div>
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