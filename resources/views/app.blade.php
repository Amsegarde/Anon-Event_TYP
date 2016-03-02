<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#42a5f5">
		<title>Anon-Event</title>
		
		<!-- Including the jQuery libraries -->
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

	    <!-- Latest compiled and minified Bootstrap JavaScript library -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
				color: gray;
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
				-webkit-filter: grayscale(60%);
                -moz-filter: grayscale(60%);
                -o-filter: grayscale(60%);
                -ms-filter: grayscale(60%);
                filter: grayscale(60%);
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

			/* Added by Jonny */
			.alert.parsley {
	            margin-top: 5px;
	            margin-bottom: 0px;
	            padding: 10px 15px 10px 15px;
	        }

	        .check .alert {
	            margin-top: 20px;
	        }

	        #browse_card {
	        	width: 35%;
	        	height: 150%;
	        }

	        #browse {
	        	max-height:200px;
	        }

	        body {
				display: flex;
				min-height: 100vh;
				flex-direction: column;
				background: #e8eddf !important;
			}

			footer {
				background: #333533 !important;
			}

			main {
				flex: 1 0 auto;
			}

			.btn {
				background: #f5cb5c !important;
				color: #242423 ;
			}

			.title {
				color: #333533 !important;
			}
			ul li a {
				color: #f5cb5c !important;
			}
		</style>

	</head>


	<body>
	
	<header>
		<!-- Dropdown Structure -->
		<ul id="dropdown1" class="dropdown-content" style="min-width: 200px;">
			<li><a href="{{ url('/tickets') }}">Tickets</a></li>
			<li><a href="{{ url('/events') }}">Saved/Favourited</a></li>
			<li class="divider"></li>
			
			<li><a href="{{ url('events/manage') }}">Manage Events</a></li>
			<li><a href="{{ url('/organisation') }}">Organisations</a></li>
			<li><a href="{{ url('/contact') }}">Contact</a></li>
			<li class="divider"></li>

		<li><a href="{{ url('/users/account') }}">Account Settings</a></li> 
			<li class="divider"></li>
			
			<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
		</ul>


		<div class="navbar">
			<nav class="z-depth-0">
				<div class="nav-wrapper z-depth-0" >
					<a href="{{ url('/') }}" class="brand-logo"><img src="{{ asset('/images/logo.jpg') }}" style="width:150px; height:80px;"></a>
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="{{ url('/') }}">Home</a></li>
						<li><a href="{{ url('/events') }}">Browse Events</a></li>
						<li><a href="{{ url('/events/past') }}">Browse Past Events</a></li>
						@if (Auth::guest())
								<li><a class="modal-trigger" href="#login">Login</a></li>
								<!-- <li><a href="{{ url('/auth/login') }}">Login</a></li> -->
								<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@else
							<li><a href="{{ url('events/create') }}">Create Event</a></li>
							<li><a href="{{ url('organisation/create') }}">Create Organisation</a></li>
							<!-- Dropdown Trigger -->
						      <li><a class="dropdown-button" href="#!" data-activates="dropdown1" style="min-width: 200px;">{{ Auth::user()->firstname }}<i class="material-icons right">arrow_drop_down</i></a></li>
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
								
								<li><a href="{{ url('events/manage') }}">Manage Events</a></li>
								<li><a href="{{ url('/organisations') }}">Organisations</a></li>
								<li><a href="{{ url('/contact') }}">Contact</a></li>
								<li class="divider"></li>

								<li><a href="{{ url('/users/account') }}">Account Settings</a></li>
								<li class="divider"></li>
								
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						@endif
					</ul>

				</div>
			</nav>
		</div>
	</header>

	<div id="login" class="modal">
		<div class="modal-content">
			<div class="row">
				<h5>Login</h5>
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				{!! Form::open(array('url'=>'/auth/login','method'=>'POST', 'class'=>'col s12')) !!}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">
						<div class="input-field">
							{!! Form::label('email', 'E-mail Address') !!}
							{!! Form::email('email', null) !!}
						</div>

						<div class="input-field">
							{!! Form::label('password', 'Password') !!}
							{!! Form::password('password', null) !!}
						</div>

						<div class="input-field">
							<p>
								<input type="checkbox" id="remember" namd="remember" />
								<label for="remember">Remember Me</label>
							</p>
						</div>

						<div class="input-field">
							{!! Form::submit('Login', ['class'=>'btn indigo lighten-1']) !!}
						</div>

						<div class="input-field">
							<a href="{{ url('/password/email') }}">Forgot Your Password?</a>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
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
		<main>
			<div class="container">
				@yield('content')
			</div>
		</main>

		<footer class="page-footer">
			<div class="footer-copyright">
				<div class="container">
					© 2016 Copyright Anon-Event
					<a class="right" href="#!"></a>
				</div>
			</div>
		</footer>

	<script>
		$(document).ready(function() {
			$('select').material_select();
			$('.modal-trigger').leanModal();
			$('.slider').slider({indicators: false, height: 600});
		});
	</script>


	<script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <!-- Inlude Stripe.js -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('{!! env('STRIPE_PK') !!}');

        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);

                // Before passing data to Stripe, trigger Parsley Client side validation
                $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                    formInstance.submitEvent.preventDefault();
                    return false;
                });

                // Disable the submit button to prevent repeated clicks
                $form.find('#submitBtn').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('.payment-errors').addClass('alert alert-danger');
                $form.find('#submitBtn').prop('disabled', false);
                $('#submitBtn').button('reset');
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        };
    </script>

    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      function initAutocomplete() {

        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        autocomplete2 = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
            {types: ['geocode']});
      }

      

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate(x) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            
            autocomplete.setBounds(circle.getBounds());
            autocomplete2.setBounds(circle.getBounds());           
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADKoGtBpXI6Ln2B8_L3_HfAS7J30z1Lno&signed_in=true&libraries=places&callback=initAutocomplete"
        async defer></script>

	</body>
</html>
