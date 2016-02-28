@extends('app')

@section('splash')
@if ($event->image != null)
	<div class="parallax-container">
		<div class="parallax"><img class="responsive-img" src="{{ asset('images/events/').'/'.$event->id.'.'.$event->image }}"></div>
		<div class="caption center-align" style="margin-top:200px;">
			<h1>{!! $event->name !!}</h1>
			<h5><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h5>
		</div>
	</div>
@else
	<div class="section indigo lighten-3" id="event_blank">
		<div class="caption center-align">
			<h1>{!! $event->name !!}</h1>
			<h3><a href="{{ url('/organisation/' . $organisation->id) }}">{!! $organisation->name !!}</a></h3>
		</div>
	</div>
@endif
@endsection

@section('content')
	
<!-- ToDo 
	Event description etc
	Upoad media
	Display media

	Have admin for media
 -->
 	<div class="row" id="event_body" style="margin-top: -60px; background: white;">
		<div class="col s12">
			<div class="row">
				@if ($isAdmin === true)
					<ul class="tabs">
						<li class="tab col s6"><a href="#desc">Description</a></li>
						<li class="tab col s6"><a href="#media">Monitor Media</a></li>
					</ul>
				@endif
				<div id="desc">
					<div class="col s12">
						<h5 class="title" align="middle">Description</h5>
						<div class="divider"></div>
						<p>{!! $event->bio !!}</p>
					</div>
					<!-- Itinerary -->
					<div class="col s12">
							@foreach ($itin as $it)
								<div class="col s8 offset-s2">
									<h5 align="middle">{!! $it->name !!}</h5>
									<p>Date: {{ $it->date }}</p> 
									<!-- <p>Time: {{ $it->time }}</p> -->
									<p>{{ $it->blurb }}</p>
									<p>The Cost of the extra event is €{{ $it->cost }}</p>
									<p>There is limited spaces to this event, {{ $it->capacity }} tickets are remaining</p>
								</div>
							@endforeach
					</div>

					<div class="divider col s12"></div>
					<div class="col s6">
						<h6 class="title">Where</h4>
						<p>{{ $event->location }}</p>
					</div>
					<div class="col s6">
						<h6 class="title">When</h6>
						<p>{{ date('F d, Y', strtotime($event->start_date)) }} - {{ date('F d, Y', strtotime($event->end_date)) }}</p>
					</div>
					<div class="divider col s12"></div>
					<div class="row col s12">
						<h5 class="title" align="middle">Event Media</h5>
						@if (count($medias) != 0)

							<div class="carousel">
								@foreach ($medias as $media) 
									<a class="carousel-item" href="{!!'#img' . $media->id !!}">
										<img src="{{ asset('images/media'.'/'.$media->id.'.'.$media->media) }}"> <!-- style="width:250; heigth:250;"> -->
									</a>
								@endforeach
							</div>

							<div class="carousel carousel-slider">
								@foreach ($medias as $media) 
									<a class="carousel-item" href="{!!'#img' . $media->id !!}">
										<img src="{{ asset('images/media'.'/'.$media->id.'.'.$media->media) }}"> <!-- style="width:800 !impo; heigth:400;"> -->
									</a>
								@endforeach
							</div>
						@else
							<p align="middle">There is no media for this event</p>
						@endif

						<!-- @if (auth::guest())
							<p>You must be logged in, in order to upload media</p>
							<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
						 -->
							<div class="row col s12">
								{!! Form::open(array('url' => 'media', 'files' => 'true', 'class' => 'form')) !!}
								{!! Form::hidden('user_id', auth::id()) !!}
								{!! Form::hidden('event_id', $event->id) !!}
									<h5 class="title col s12">Upload Event media</h5>
									<p>You can upload files of the following size and type:</p>
									<ul>
										<li>Image Size:</li>
										<li>Image Types:</li>
										<li>Video Size:</li>
										<li>Video Types:</li>
									</ul>
									<div class="divider col s12"></div>

									<div class="file-field input-field col s12">
										<div class="btn indigo lighten-1">
											<span>Upload Event Media</span>
											<input name="image" type="file">
										</div>				
										<div class="file-path-wrapper">
											<input class="file-path validate type="text>
										</div>
									</div>

									<div class="input-field col s12">
										{!! Form::submit('Upload Media!', array('class'=>'btn indigo lighten-1')) !!}
									</div>
								{!! Form::close() !!}
							</div>
						<!-- @endif -->
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
			$('.carousel').carousel();
		});
	</script>
@endsection