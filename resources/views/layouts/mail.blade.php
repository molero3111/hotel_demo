<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}"/> --}}

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('lib/bootstrap/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('lib/bootstrap/js/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('lib/datepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/hotel_functions.js') }}"></script> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}"/>
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('lib/datepicker/jquery.datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/w3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/fonts.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/main_styles.css') }}"/> 
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome-free-5.13.0-web/css/all.css') }}"/>
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
    <!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>  -->
</head>
<body>
	<nav class="navbar navbar-expand-md header navbar-dark w3-animate-bottom shadow" >
	<!-- Brand -->
		<span class="mail-logo w3-animate-right w-50">
			<a class="mail-title" href="#">Hotel Inverdata</a>
		</span>
	</nav>
	<div class="navbar-space"></div>
	<div id="mail-content-displayer">
        @yield('content')
    </div>
	<footer class="bg-transparent-black text-hotel-orange mt-5">
        <div class="container">
            </div>
                <p class="social text-hotel-orange">
                    <i class="fab fa-facebook-square"></i>
                    <i class="fab fa-instagram-square"></i>
                    <i class="fab fa-twitter-square"></i>
                    <i class="fab fa-google-plus-square"></i>
                </p>
                <p class="text-center text-hotel-orange mt-2 mb-2">
                    Copyright © 2020 - Hotel Inverdata.
                </p>
        </div>
	</footer>
</body>
</html>