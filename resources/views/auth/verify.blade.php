@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
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
        <div class="text-white carousel-form w3-animate-zoom">
            <h2 class="text-center form-text text-white ">{{ __('Verify Your Email Address') }}</h2>
            <p class="text-center form-text text-white "> {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a id="resend" href=#>{{ __('click here to request another') }}</a>.
            </p>
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
        </div>
        {{-- <div class="row justify-content-center text-white  carousel-form w3-animate-zoom">
            <div class="col-md-8">
                <div class="card carousel-content-color">
                    <div class="card-header text-center form-text text-white">{{ __('Verify Your Email Address') }}</div>
    
                    <div class="card-body form-text text-white">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
    
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<script>
    $('#resend').on('click',function (e) {
        e.preventDefault();
        $('.waiting').fadeIn();
        $.ajax( {
            method: "POST",
            url: "{{ route('verification.resend') }}",
            data: {_token:'{{csrf_token()}}'},
            success: (serverResponse) => {
                $('.waiting').fadeOut();
                swal({
                title: "Correo enviado.",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: '<p class="swal-color">Su correo de verificación fue enviado existosamente. ya puede proceder a verificar su cuenta.</p>'
                    }
                },
                icon: "success",
                button: "Aceptar",
                className: "alert"
                }).then((value)=>{location.href='/'});
            },
            error: (serverResponse) => { console.log(serverResponse);
                $('.waiting').fadeOut();
                displaySwal('<p class="swal-color">Hubo un error con su correo de verificación, intente nuevamente.</p>');
             }//error
            });
       });    
</script>
@endsection
