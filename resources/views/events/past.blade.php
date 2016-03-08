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
							@foreach ($itinArrays as $itinArray)
								<div class="col s8 offset-s2">
									<h5 align="middle">{!! $itinArray->name !!}</h5>
									<p>Date: {{ $itinArray->date }}</p> 
									<p>{{ $itinArray->blurb }}</p>
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
							@foreach ($medias as $media)
								<div class="col s6">
									@if ($media->media == 'jpg' || $media->media == 'jpeg' || $media->media == 'png')
										<img class="materialboxed responsive-img" width="300" src="{{ asset('images/media/'.$media->id.'.'.$media->media) }}">
									@endif
								</div>
							@endforeach

							@foreach ($medias as $media)
								@if ($media->media == 'mp4')
									<div class="col s6">
										<video class="responsive-video" controls>
											<source src="{{ asset('images/media/'.$media->id.'.'.$media->media) }}" type="video/mp4">
										</video>
									</div>
								@endif
							@endforeach
						@else
							<p align="middle">There is no media for this event</p>
						@endif

						@if (auth::guest())
							<p>You must be logged in, in order to upload media</p>
							<p><a href="{{ url('/auth/login') }}">Log in</a> or <a href="{{ url('/auth/register') }}">Register</a></p>
						@else
							<div class="row col s12">
								{!! Form::open(array('url' => 'media', 'files' => 'true')) !!}
									{!! Form::hidden('user_id', auth::id()) !!}
									{!! Form::hidden('event_id', $event->id) !!}
									<h5 class="title col s12">Upload Images</h5>
									<p>You can upload files of the following size and type:</p>
									<ul>
										<li>Image Size:</li>
										<li>Image Types: jpeg, jpg or png</li>
									</ul>
									<div class="divider col s12"></div>

									<!-- Image Upload -->
									<div class="file-field input-field col s12">
										<div class="btn">
											<span>Upload Images</span>
											<input name="image" type="file">
										</div>				
										<div class="file-path-wrapper">
											<input class="file-path validate type="text>
										</div>
									</div>

									<div class="input-field col s12">
										{!! Form::submit('Upload Images!', array('class'=>'btn col s6 offset-s3')) !!}
									</div>
								{!! Form::close() !!}
							</div>

							<div class="row col s12">
								{!! Form::open(array('url' => 'media', 'files' => 'true')) !!}
									{!! Form::hidden('user_id', auth::id()) !!}
									{!! Form::hidden('event_id', $event->id) !!}
									<h5 class="title col s12">Upload Videos</h5>
									<p>You can upload files of the following size and type:</p>
									<ul>
										<li>Video Size:</li>
										<li>Video Types: mp4</li>
									</ul>
									<div class="divider col s12"></div>

									<!-- Video upload -->
									<div class="file-field input-field col s12">
										<div class="btn">
											<span>Upload Videos</span>
											<input name="video" type="file">
										</div>				
										<div class="file-path-wrapper">
											<input class="file-path validate type="text>
										</div>
									</div>

									<div class="input-field col s12">
										{!! Form::submit('Upload Video!', array('class'=>'btn col s6 offset-s3')) !!}
									</div>
								{!! Form::close() !!}
							</div>
						@endif
					</div>
				</div>

				<div id="media">
					@foreach ($medias as $media)
						@if ($media->flagged == 1)	
							@if ($media->media == 'jpg' || $media->media == 'jpeg' || $media->media == 'png')
								<div class="col s6">
									<img class="materialboxed responsive-img" width="300" src="{{ asset('images/media/'.$media->id.'.'.$media->media) }}">
								</div>
							@endif

							@if ($media->media == 'mp4')
								<div class="col s6">
									<video class="responsive-video" controls>
										<source src="{{ asset('images/media/'.$media->id.'.'.$media->media) }}" type="video/mp4">
									</video>
								</div>
							@endif
						@endif
					@endforeach
				</div>

			</div>
		</div>
	</div>

	<script>

	</script>
@endsection