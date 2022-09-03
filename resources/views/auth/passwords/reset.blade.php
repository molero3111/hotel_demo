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

        <form action="{{ route('password.update') }}" class="text-white carousel-form w3-animate-zoom" id="resetPasswordForm">
            <h2 class="form-text text-white text-center mb-3">{{ __('Reset Password') }}</h2>
            <div class="form-group form-element-width">
                <label class="form-text" for="email">{{ __('E-Mail Address') }}:</label>
                <input type="email" class="form-control hotel_input shadow"
                id="email" value="{{ $email ?? old('email') }}" placeholder="Ingrese Correo..."
                name="email" required autocomplete="email" autofocus>
            </div>
            <div class="form-group form-element-width">
                <label class="form-text" for="password">{{ __('Password') }}:</label>
                <input type="password" class="form-control hotel_input shadow"
                id="password" placeholder="Ingrese contraseña..."
                name="password" required autocomplete="password" autofocus>
            </div>
            <div class="form-group form-element-width">
                <label class="form-text" for="password-confirm">{{ __('Confirm Password') }}:</label>
                <input type="password" class="form-control hotel_input shadow"
                id="password-confirm" placeholder="Confirme contraseña..."
                name="password_confirmation" required autocomplete="password-confirm" autofocus>
            </div>
            <input type="hidden" id="_token" name="_token" value='{{csrf_token()}}' />
            <input type="hidden" name="token" value="{{ $token }}">
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
            <button type="button" id="passwordResetBtn" 
            class="reservation_search_btn  text-dark mt-3">
            {{ __('Reset Password') }}</button>
        </form>
    </div>
</div>  
<script>
$('#passwordResetBtn').on('click',function () {
    $('.waiting').css('display', 'block');
    $.ajax( {
        method: "POST",
        url: "{{ route('password.update') }}",
        data: $('#resetPasswordForm').serialize(),
        success: (serverResponse) => { 
            $('.waiting').css('display', 'none');
            swal({
                title: "Contraseña re-establecida con éxito.",
                text: "Su fue re-establecida sin problemas, ya puede seguir disfrutando de nuestros"+
                " servicios.",
                icon: "success",
                button: "Aceptar",
                className: "alert",
            }).then((value)=>{location.href="{{ route('home') }}";});
        },
        error: (serverResponse) => {
            $('.waiting').css('display', 'none');
            let errors = '';
            let isFirst=true;

            errors += process422Errors(serverResponse.responseJSON.errors.email, 
            'E-Mail', true);
            errors += process422Errors(serverResponse.responseJSON.errors.password, 
            'Contraseña', true);
            errors += process422Errors(serverResponse.responseJSON.errors.password_confirmation, 
            'Confimar contraseña', true);
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
