<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#42a5f5">
		<title>Anon-Event</title>

		{!! MaterializeCSS::include_css() !!}
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<!-- This is the js for the textarea -->
		<script src="//cdn.ckeditor.com/4.5.7/basic/ckeditor.js"></script>

  		<!-- TICKET PAGE CANCEL ORDER BOOTSTRAP -->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Latest compiled and minified CSS -->
		<!-- These are for the datetimePicker -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->

		<!-- Optional theme -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" /> -->

		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>    -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
		
		<style type="text/css">
			nav {
				background: none;
				position: relative;
				z-index: 1;
			}
			nav li a {
				color: black;
			}

			.brand-logo {
				color: black !important;
			}

			.parallax {
				height: 95%;
			}

			#home {
				margin-top: -64px;
				padding-top: 64px;
			}



			.parallax img {
				display: inherit !important;
			}

			#event_blank {
				height: 200px;
			}

			.caption {
				bottom:0;
			}

			.title {
				color: blue;
			}

			.ticketSelect {
				display: inherit !important;
			}
		</style>

	</head>


	<body>
		
		
		<!-- Dropdown Structure -->
		<ul id="dropdown1" class="dropdown-content">
			<li><a href="{{ url('/tickets') }}">Tickets</a></li>
			<li><a href="{{ url('/events') }}">Saved/Favourited</a></li>
			<li class="divider"></li>
			
			<li><a href="{{ url('/eventDashboard') }}">Manage Events</a></li>
			<li><a href="{{ url('/organisation') }}">Organisations</a></li>
			<li><a href="{{ url('/contact') }}">Contact</a></li>
			<li class="divider"></li>

			<li><a href="{{ url('/auth/logout') }}">Account Settings</a></li>
			<li class="divider"></li>
			
			<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
		</ul>


		<div class="navbar">
			<nav style>
				<div class="nav-wrapper" >
					<a href="{{ url('/') }}" class="brand-logo">Anon-Event</a>
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="{{ url('/') }}">Home</a></li>
						<li><a href="{{ url('/events') }}">Browse Events</a></li>
						@if (Auth::guest())
								<li><a href="{{ url('/auth/login') }}">Login</a></li>
								<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@else
							<li><a href="{{ url('events/create') }}">Create Event</a></li>
							<li><a href="{{ url('organisation/create') }}">Create Organisation</a></li>
							<!-- Dropdown Trigger -->
						      <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{{ Auth::user()->firstname }}<i class="material-icons right">arrow_drop_down</i></a></li>
						@endif
					</ul>
					<ul class="side-nav" id="mobile-demo">
						<li><a href="{{ url('/') }}">Home</a></li>
						@if (Auth::guest())
							<li><a href="{{ url('/auth/login') }}">Login</a></li>
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@else
							<li><a href="{{ url('events/create') }}">Create Event</a></li>
							<li><a href="{{ url('organisations/create') }}">Create Organisation</a></li>
							<li class="divider"></li>
							<li class="divider"></li>
							<ul>
								<li><a href="{{ url('/tickets') }}">Tickets</a></li>
								<li><a href="{{ url('/events') }}">Saved/Favourited</a></li>
								<li class="divider"></li>
								
								<li><a href="{{ url('/eventDashboard') }}">Manage Events</a></li>
								<li><a href="{{ url('/organisations') }}">Organisations</a></li>
								<li><a href="{{ url('/contact') }}">Contact</a></li>
								<li class="divider"></li>

								<li><a href="{{ url('/auth/logout') }}">Account Settings</a></li>
								<li class="divider"></li>
								
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						@endif
					</ul>

				</div>
			</nav>
		</div>

		<!-- Scripts -->
		<script src="//code.jquery.com/jquery-2.1.2.min.js"></script>
		{!! MaterializeCSS::include_js() !!}
		<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script> -->

		<script>
			$( document ).ready(function(){
				$('.button-collapse').sideNav({
				 	menuWidth: 300, // Default is 240
				 	edge: 'right', // Choose the horizontal origin
				 	closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
				 }
				 );
			})	 
		</script>

		@yield('splash')

		<div class="container">
			@yield('content')
		</div>
		
		<footer class="page-footer blue-grey">
			<!-- <div class="container">
				<div class="row">
					<div class="col s6">
						<h5 class = "white-text">Events</h5>
						<ul>
							<li><a class="grey-text text-lighten-3" href="{{ url('events/create') }}">Create Event</a></li>
							<li><a class="grey-text text-lighten-3" href="{{ url('events') }}">Browse Events</a></li>
							<li><a class="grey-text text-lighten-3" href="{{ url('events/past') }}">Browse Past Events</a></li>
						</ul>
					</div>
					<div class="col s6">
						<h5 class="white-text">Links</h5>
						<ul>
							<li><a class="grey-text text-lighten-3" href="about">About</a></li>
							<li><a class="grey-text text-lighten-3" href="contact">Contact Us</a></li>
						</ul>
					</div>
				</div>
			</div> -->
			<div class="footer-copyright">
				<div class="container">
					© 2016 Copyright Anon-Event
					<a class="grey-text text-lighten-4 right" href="#!"></a>
				</div>
			</div>
		</footer>


	</body>
</html>
