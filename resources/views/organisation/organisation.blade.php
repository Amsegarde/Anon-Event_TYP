@extends('app')

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"></div>

				<div class="panel-body">
					<h1>{!! $org->name !!}</h1>

					<p>{!! $org->bio !!}</p>

					<img style="max-width:500px; max-height:500px;" src="{{ asset('images/organisations/').'/'.$org->id.'.'.$org->image }}">
					
					@if  (Auth::guest())

					@elseif ($isAdmin === true)
						<p>	<a class="waves-effect waves-light btn modal-trigger" href="#modal2">Contact Followers</a></p>
						<!-- Modal Structure -->
						<div id="modal2" class="modal">
					    	<div class="modal-content">
						    	<h4>Contact Followers</h4>

								<ul>
								    @foreach($errors->all() as $error)
								        <li>{{ $error }}</li>
								    @endforeach
								</ul>

								{!! Form::open(array('route' => 'contact_followers', 'class' => 'form')) !!}
									{!! Form::hidden('organisationID', $org->id) !!}
									
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
					@elseif ($hasFavourited === true) 
						{!! Form::open(array('url' => 'organisation/'. $org->id)) !!}
							{!! Form::submit('Unfavourite') !!}
						{!! Form::close() !!}
					@else
						{!! Form::open(array('url' => 'organisation/'. $org->id)) !!}
							{!! Form::submit('Favourite') !!}
						{!! Form::close() !!}
					@endif

					<script type="text/javascript">
						$(document).ready(function(){
							// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
							$('.modal-trigger').leanModal();
						});

						$(document).ready(function(){
							$('ul.tabs').tabs('select_tab', 'tab_id');
						});

						// For the Rich Text Editor
						CKEDITOR.replace( 'bio' );
					</script>
					
				</div>
			</div>
		</div>
	</div>
@endsection
