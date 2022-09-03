@extends('layouts.app')

@section('content')
<!--carousel-->
<div id="hotel_images" class="carousel slide shadow" data-ride="carousel" data-interval="5000">
       
       
    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/carousel/pool.jpg') }}" alt="Los Angeles" class="main-carousel-img">
            <div class="carousel-color"></div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/carousel/hotel_room.jpg') }}" alt="Chicago" class="main-carousel-img">
            <div class="carousel-color"></div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/carousel/hotel_lobby.jpg') }}" alt="New York" class="main-carousel-img">
            <div class="carousel-color"></div>
        </div>
        <form action="{{ route('login') }}" class="text-white  carousel-form w3-animate-zoom" id="loginForm">
            <h2 class="form-text text-white text-center mb-3">{{ __('Login') }}</h2> 
            <div class="form-group form-element-width">
                    <label class="form-text" for="email">Correo:</label>
                    <input type="email" class="form-control hotel_input shadow"
                    id="email" value="{{ old('email') }}" placeholder="Ingrese Correo..."
                    name="email" required autocomplete="email" autofocus>
                    <small id="emailhelp" class="form-text text-white">Ingrese el correo que utilizo 
                    al momento de su registro, recuerde que este debe estar verificado para disfrutar
                    de nuestros servicios.</small>
                </div>
                <div class="form-group form-element-width">
                    <label class="form-text" for="password">Contraseña:</label>
                    <input type="password" class="form-control hotel_input shadow" 
                    id="password" value="{{ old('password') }}" placeholder="Ingrese contraseña..."
                    name="password" required autocomplete="current-password">
                    <small id="passwordHelp" class="form-text text-white">Ingrese su contraseña, 
                    tenga en cuenta que su usuario puede ser bloqueado temporalmente debido a varios intentos
                    fallidos.</small>
                </div>
                <div class="form-group form-element-width mt-3">
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input"
                         id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label form-text" 
                        for="remember" style='font-size: 17px'>
                        {{ __('Recordarme') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link form-text" href="{{ route('password.request') }}">
                            {{ __('Olvisdaste tu contraseña?') }}
                        </a>
                     @endif
                    <input type="hidden" id="_token" name="_token" value='{{csrf_token()}}' />
                </div>
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
            <button type="button" id="loginBtn" class="reservation_search_btn text-dark mt-3">Iniciar Sesion</button>
        </form>
    </div>
</div>
<script>
    $('#loginBtn').on('click',function () {
        $('.waiting').css('display', 'block');
        $.ajax( {
            method: "POST",
            url: "{{route('login')}}",
            data: $('#loginForm').serialize(),
            success: (serverResponse) => { location.href='/';},
            error: (serverResponse) => { //console.log(serverResponse);
                $('.waiting').css('display', 'none');
                var errors='';
                errors += process422Errors(serverResponse.responseJSON.errors.email, 
                'E-Mail', true);
                errors += process422Errors(serverResponse.responseJSON.errors.password,
                'Contraseña', true);
                displaySwal(errors);
                
             }//error
            });
       });    
    </script> 
@endsection
