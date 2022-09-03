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

        <form action="{{ route('password.email') }}" class="text-white carousel-form w3-animate-zoom" id="loginForm">
            <h2 class="form-text text-white text-center mb-3">{{ __('Reset Password') }}</h2>
            <div class="form-group form-element-width">
                <label class="form-text" for="email">{{ __('E-Mail Address') }}</label>
                <input type="email" class="form-control hotel_input shadow"
                id="email" value="{{ old('email') }}" placeholder="Ingrese Correo..."
                name="email" required autocomplete="email" autofocus>
                <small id="emailhelp" class="form-text text-white">Ingrese el correo que utilizó 
                al momento de su registro, en esta dirección recibirá un link para re-establecer 
                su contraseña.</small>
            </div>
            <input type="hidden" id="_token" name="_token" value='{{csrf_token()}}' />
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
            <button type="button" id="passwordResetBtn" 
            class="reservation_search_btn big_hotel_button text-dark mt-3">
            {{ __('Send Password Reset Link') }}</button>
        </form>
    </div>
</div>  
<script>
$('#passwordResetBtn').on('click',function () {
    $('.waiting').css('display', 'block');
    $.ajax( {
        method: "POST",
        url: "{{ route('password.email') }}",
        data: $('#loginForm').serialize(),
        success: (serverResponse) => { 
            $('.waiting').css('display', 'none');
            swal({
                title: "Correo enviado con éxito.",
                text: "Se envió un correo a la dirección especificada con un link para "+
                "re-establecer su contraseña.",
                icon: "success",
                button: "Aceptar",
                className: "alert",
            }).then((value)=>{location.href="{{ route('login') }}";});
        },
        error: (serverResponse) => {
            $('.waiting').css('display', 'none');
            var errors = '';
            errors += process422Errors(serverResponse.responseJSON.errors.email, 
            'E-Mail', true);
            swal({
                title: "Errores encontrados, por favor verifique:",
                content: {
                    element: "p",
                    attributes: {
                    innerHTML: errors
                    }
                },
                icon: "warning",
                button: "Volver a intentar",
                className: "alert",
            });
            }//error
        });
    });    
</script> 
@endsection
