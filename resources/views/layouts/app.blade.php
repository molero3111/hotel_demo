<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel Inverdata</title>
    
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}"/> --}}

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('lib/bootstrap/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('lib/bootstrap/js/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('lib/datepicker/jquery.datetimepicker.full.min.js') }}"></script>--}}
    <script src="{{ asset('js/hotel_functions.js') }}"></script> 
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
    <div id='process_icon' class="screen_wait_container">
        <p  class="w3-animate-zoom screen_wait mt-3">
          <i class="fa fa-spinner w3-spin "></i>
        </p>
      </div>
    <nav class="navbar navbar-expand-md header navbar_index navbar-dark w3-animate-bottom shadow" >
    <!-- Brand -->
        <span class="logo w3-animate-right">
            <a class="" href="{{ route('home') }}">Hotel Inverdata</a>
        </span>
            <!-- Links -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon" ></span>
        </button>
        
       

        <div class="collapse navbar-collapse order-1 order-md-0 w3-animate-left" id="collapsibleNavbar">
            <div class="align-navbar "></div><!--used to display nav links on the right-->
            <ul class="navbar-nav hotel-text ">
                @guest
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Habitaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Promociones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contacto</a>
                </li>
                <li class="w3-dropdown-hover w3-right">
                    <a class=" nav-link nav-left text-white" href="#">
                        Acceder <i class="fa fa-caret-down"></i>
                    </a>
                    <div id="dropdown-float" class="w3-dropdown-content w3-bar-block w3-card-4 bg-light-orange w3-animate-zoom hotel-text-reverse">
                        <a class="w3-bar-item text-dark " href="{{ route('login') }}">Iniciar Sesión <i class="fas fa-sign-in-alt float-right"></i></a> 
                        @if (Route::has('register'))
                        <a class="w3-bar-item text-dark" href="{{ route('register') }}">{{ __('Registro') }} <i class="fas fa-user-plus float-right"></i></a>
                        @endif
                    </div>
                </li>
                @else
                <li class="w3-dropdown-hover w3-right">
                    <a class=" nav-link nav-left text-white" href="#" >
                        Conócenos <i class="fas fa-handshake"></i></i>
                    </a>
                    <div class="w3-dropdown-content w3-bar-block w3-card-4 bg-light-orange w3-animate-zoom hotel-text-reverse">
                        <a class="w3-bar-item text-dark" href="{{ route('home') }}#mission_vision">Misión y Visión</a>
                        <a class="w3-bar-item text-dark" href="{{ route('home') }}#rooms">Habitaciones</a>
                        <a class="w3-bar-item text-dark" href="{{ route('home') }}#promotions">Promociones</a>
                        <a class="w3-bar-item text-dark" href="{{ route('home') }}#contact">Contacto <i class="fas fa-address-card float-right"></i> </a>
                    </div>
                </li>
                <li class="w3-dropdown-hover w3-right">
                    <a class=" nav-link nav-left text-white" href="#" >
                        {{ Auth::user()->email }} <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="w3-dropdown-content w3-bar-block w3-card-4 bg-light-orange w3-animate-zoom hotel-text-reverse">
                        <a class="w3-bar-item text-dark" href="{{ route('profile') }}">Perfil <i class="fas fa-id-badge float-right"></i></a>
                        <a class="w3-bar-item text-dark" href="{{ route('user_people') }}">Personas <i class="fas fa-people-arrows float-right"></i></a>
                        <a class="w3-bar-item text-dark" href="{{ route('user_reservations') }}">Reservas <i class="fas fa-hotel float-right"></i></a>
                        <a class="w3-bar-item text-dark" href="{{ route('client_products') }}">Productos <i class="fas fa-shopping-cart float-right"></i></a>
                        @if(Auth::user()->user_role_id >= 2  && Auth::user()->user_role_id <= 3)
                            <a class="w3-bar-item text-dark" href="{{ route('admin_panel') }}" target='_blank'>Administrar <i class="fas fa-users-cog float-right"></i></a>
                        @endif
                        <script>console.log('auth', '{{Auth::user()}}');</script>
                        <a class="w3-bar-item text-dark" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Salir') }} <i class="fas fa-sign-out-alt float-right"></i>
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </div>  
        <button type="button" class="hotel_button hotel_button_navbar hide text-dark">Reserva Online</button>
        <button type="button" class="hotel_button hotel_button_navbar hide-btn text-dark"><i class="fas fa-phone"></i></i> +584140660505</button>
    </nav>
    <div class="navbar-space"></div>
{{-- content --}}
    <div id="content-displayer">
        @yield('content')
    </div>
{{-- content --}}
    <footer class="bg-transparent-black text-hotel-orange mt-3">
        <div class="container">
            <div class="row">
                <span class="logo mt-3">
                    <a class="" href="#">Hotel Inverdata</a>
                </span>
            </div>
            <div class="row mt-3">
                <div class="card-group">
                    <div class="card bg-transparent border-reset">
                        <div class="card-body text-center">
                            <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                                <div class="feature-text"><i class="fas fa-location-arrow"></i></div>
                                <div class=""><h3>Dirección</h3></div>
                                <div class="text-justify">
                                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-transparent border-reset">
                        <div class="card-body text-center">
                            <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                                <div class="feature-text"><i class="fas fa-map-marked-alt"></i></div>
                                <div class=""><h3>Ubicación</h3></div>
                                    <iframe class="map shadow" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501277.88368504186!2d-64.3736204160484!3d11.021102340636931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8c31f1a90b8eb173%3A0x8f83879d37efd85e!2sIsla%20de%20Margarita!5e0!3m2!1ses-419!2sve!4v1586694858934!5m2!1ses-419!2sve" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                              
                                </div>
                        </div>
                    </div>
                    <div class="card bg-transparent border-reset">
                        <div class="card-body text-center">
                            <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                                <div class="feature-text"><i class="fas fa-certificate"></i></div>
                                <div class=""><h3>Certificaciones</h3></div>
                                <div class="text-justify">
                                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--footer-features-->
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
    <script>

        let dates = [{id:'check_in', value:getCurrentDate()},
        { id:'check_out', value:getCurrentDate(true)}];

        $.datetimepicker.setLocale('es');
        for(let i = 0; i < dates.length; i++){

            $('#'+dates[i].id).datetimepicker({
            timepicker:false,
            datepicker:true,
            format: 'd-m-Y',
            value: dates[i].value,
            weeks:true,
            theme:'dark',
            mask: true,
            lang: 'es'
            });
        }
    
    //Tooltips
    $(function () {  $('[data-toggle="tooltip"]').tooltip()  });
    </script>
</body>
</html>