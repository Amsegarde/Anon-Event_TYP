@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<h3>About Anon-Event</h3>
				<div class="panel-body">

					<h5>Who are we?</h5>
					<p>
						Anon-Event are the greatest thing going. We are developing amazing events at amazing rates for amazing people doing amazing things. 
					</p>
					<h5>What do we do?</h5>
					<p>
						We efficiently use buzzwords to really get the point across that we know what we're talking about. For example, we often use the word "efficient", in presentations to really get the investors salivating at our universally applicable (more buzzwords) applications that we can market to any range of an audience, young or old (not buzzwords, but you're definitely more confident in our product now aren't you.)
					</p>
					<h5>Where do we come from?</h5>
					<p>
						As a relatively secretive organisation, we at Anon-Event like to keep our private lives exactly that, private. However, our lead designer, project manager and all round go-to guy, Seán Cronin, lives in Grange Douglas, and is always welcoming to strangers on his door, so feel free to pop by for a cup of tea, or a discussion how we at Anon-Event can better your usage of buzzwords and make events more fun for you.
					</p>
					<h5>Why do we do it?</h5>
					<p>
						Anon-Event have been working as part of the event organisation business for the last decade and a half. We developed from a small startup in Seáns garage, hitting stolen laptops with rocks, trying to find the "On" button, to a startup that is now fully capable of using Google Chrome. We are now working on finding out how to remove ads from all sites, and hope to have an efficient and succinct (more buzzwords, we're really good at what we do) solution by the end of 2018
					</p>
					<h5>How to get in contact with us?</h5>
					<p>
						If you would like to contact Anon-Event, feel free to call Seán Leroy personally at djseancronin@gmail.com. Or alternatively go to our <a href="{{ url('about/contact') }}">Contact Us Page</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
