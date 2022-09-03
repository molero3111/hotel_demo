@extends('layouts.app')

@section('content')
<!--carousel-->
<div id="hotel_images" class="carousel slide shadow" data-ride="carousel" data-interval="5000">
       
       
    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/carousel/pool.jpg') }}" alt="Los Angeles" class="main-carousel-img-large">
            <div class="carousel-color-large"></div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/carousel/hotel_room.jpg') }}" alt="Chicago" class="main-carousel-img-large">
            <div class="carousel-color-large"></div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/carousel/hotel_lobby.jpg') }}" alt="New York" class="main-carousel-img-large">
            <div class="carousel-color-large"></div>
        </div>
        <form action="/" class="text-white  carousel-form-large w3-animate-zoom" id="loginForm">
            <h2 class="form-text text-white text-center mb-3">{{ __('Register') }}</h2> 
            <div class="row">
            <div class="input-group mb-3  col-sm-6">
                <div class="input-group-prepend">
                    <select id="id_number_type" name="id_number_type"
                    class="custom-select hotel_input shadow">
                        <option selected>{{$data['id_number_types'][0]}}</option>
                        @for ($i = 1; $i < count($data['id_number_types']); $i++)
                            <option>{{$data['id_number_types'][$i]}}</option>
                        @endfor                        
                    </select>  
                </div>
                <input type="text" id="id_number" name="id_number" class="form-control  hotel_input shadow" 
                placeholder="Ingrese su número de identificación...">
            </div>
            </div>
            <div class="row ">
            <div class="form-group mb-3 form-element-width col-sm-6">
                <label class="form-text" for="name">{{ __('Name') }}:</label>
                <input type="text" class="form-control hotel_input shadow"
                id="name" value="{{ old('name') }}" placeholder="Ingrese su primer nombre..."
                name="name" required autocomplete="name" autofocus
                maxlength="40">
            </div>
            <div class="form-group mb-3 form-element-width col-sm-6">
                <label class="form-text" for="lastname">Apellido:</label>
                <input type="text" class="form-control hotel_input shadow" 
                id="lastname" value="{{ old('lastname') }}" placeholder="Ingrese su apellido..."
                name="lastname" required autocomplete="lastname"
                maxlength="40">
            </div>
            </div>
            <hr/>
            <div class="row">
            <div id="countryForm" class="form-group mb-3 form-element-width col-sm-6">
                <label class="form-text" for="country">País:</label>
                <select name="country" id="country" class="custom-select hotel_input shadow">
                    <option selected>Seleccione País</option>
                    @for ($i = 0; $i < count($data['countries']); $i++)
                        <option>{{$data['countries'][$i]}}</option>
                    @endfor                        
                </select>
            </div>
            <div id="regionForm"  class="form-group mb-3 form-element-width col-sm-6">
                <label class="form-text" for="country">Estado:</label>
                <select name="region" id="region" disabled
                class="custom-select hotel_input shadow">
                    <option>Seleccione estado...</option>
                </select>
            </div>
            {{-- </div> --}}
            {{-- <div class="row"> --}}
            <div id="localityForm"  class="form-group mb-3  col-sm-6">
                <label class="form-text" for="locality">Ciudad:</label>
                <select name="locality" id="locality" disabled
                class="custom-select hotel_input shadow">
                    <option>Seleccione ciudad...</option>                 
                </select>
            </div>
            </div>
            <hr/>
            <div class="row">
            <div class="form-group form-element-width col-sm-12 mb-3">
                <label class="form-text" for="lastname">Dirección:</label>
                <textarea type="text" class="form-control hotel_input shadow" 
                id="address" value="{{ old('address') }}" placeholder="Ingrese su dirección..."
                name="address" required autocomplete="address"
                maxlength="150" style="resize:none;"></textarea>
            </div>
            </div>
            <div class="row">
            <div class="form-group form-element-width col-sm-6 mb-3">
                <label class="form-text" for="name">Teléfono:</label>
                <input type="text" class="form-control hotel_input shadow"
                id="phone_number" value="{{ old('phone_number') }}" placeholder="Ingrese su número de teléfono..."
                name="phone_number" required autocomplete="phone_number" autofocus
                maxlength="30">
            </div>
            <div class="form-group form-element-width col-sm-6 mb-3">
                <label class="form-text" for="name">Fecha de nacimiento:</label>
                <input type="text" class="form-control hotel_input shadow"
                id="birth_date" value="{{ old('birth_date') }}" placeholder="Fecha de nacimiento, formato DD-MM-YYYY..."
                name="birth_date" required autocomplete="birth_date" autofocus
                maxlength="10">
            </div>
            </div>
            <hr />
            <div class="row">
            <div class="form-group col-sm-6 mb-3">
                <label class="form-text" for="name">{{ __('E-Mail Address') }}:</label>
                <input type="text" class="form-control hotel_input shadow"
                id="email" value="{{ old('email') }}" placeholder="Ingrese su correo electrónico..."
                name="email" required autocomplete="email" autofocus
                maxlength="100">
            </div>
            </div>
            <div class="row">
            <div class="form-group form-element-width col-sm-6 mb-3">
                <label class="form-text" for="name">{{ __('Password') }}:</label>
                <input type="password" class="form-control hotel_input shadow"
                id="password" value="{{ old('password') }}" placeholder="Ingresa una contraseña..."
                name="password" required autocomplete="password" autofocus
                maxlength="50">
            </div>
            <div class="form-group form-element-width col-sm-6 mb-3">
                <label class="form-text" for="name">{{ __('Confirm Password') }}:</label>
                <input type="password" class="form-control hotel_input shadow"
                id="password_confirmation" value="{{ old('password-confirm') }}" placeholder="Confirme su contraseña..."
                name="password_confirmation" required autocomplete="password-confirm" autofocus
                maxlength="50">
            </div>
            </div>
            <input type="hidden" id="_token" name="_token" value='{{csrf_token()}}' />
                
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
            <button type="button" id="regiterBtn" class="reservation_search_btn register_btn text-dark mt-3">Registrar</button>
        </form>
    </div>
</div>
<script>
    attachDatePicker('#birth_date','');
    var data;
    var optionTags='';
    function countryDataAjaxRequest(route, data, fieldName, parentSelectId, childSelectId) {
        
        $('#'+childSelectId+'Form').append('<p hidden class="w3-animate-zoom append-wait-icon mt-3"><i class="fa fa-spinner w3-spin "></i></p>');
        $('#'+childSelectId+'Form p').fadeIn();
        $.ajax({
            method: "POST",
            url: route,
            data: data,
            beforeSend: ()=>{
                
            },
            success: (serverResponse) => { 
                $('#'+childSelectId+'Form p').fadeOut();
                $('#'+childSelectId).empty();
                // if(parentSelectId=='country'){ $('#locality').empty();
                // $('#locality').append('<option>Seleccione ciudad...</option>');
                // $('#locality').attr('disabled', true);}
                

                if(serverResponse.icon){  return swal(serverResponse);  }
                optionTags='';
                if(childSelectId=='region'){optionTags = '<option>Seleccione estado...</option>';}
                else {optionTags = '<option>Seleccione ciudad...</option>';}
                
                for( let i = 0; i < serverResponse.length; i++){
                    optionTags += '<option>'+serverResponse[i]+'</option>';
                }
                // $('#'+childSelectId).append(optionTags);
                // $('#'+childSelectId).attr('disabled', false);
            },
            error: (serverResponse) => { 
                $('#'+childSelectId+'Form p').fadeOut();
                displaySwal(process422Errors(serverResponse.responseJSON.errors[parentSelectId], 
                fieldName));
            }//error
        })//ajax
        .done(function (){

            $('#'+childSelectId).append(optionTags);
            $('#'+childSelectId).attr('disabled', false);
            if(parentSelectId=='country'){ $('#locality').empty();
            $('#locality').append('<option>Seleccione ciudad...</option>');
            $('#locality').attr('disabled', true);}
        });//done
    }//countryDataAjaxRequest
    
    $('#country').on('change', function (params) {
        data = null;
        data = {
            country: $('#country').val(),
            _token: '{{csrf_token()}}'
        }
        countryDataAjaxRequest("{{ route('regions') }}", data, 'País', 'country' ,'region');
    });//end
    $('#region').on('change', function (params) {
        data = null;
        data = {
            region: $('#region').val(),
            _token: '{{csrf_token()}}'
        }
        countryDataAjaxRequest("{{ route('localities') }}", data, 'Estado', 'region', 'locality');
    });//end

$('#regiterBtn').on('click', function () {
    $('p.waiting').fadeIn();
    $.ajax({
            method: "POST",
            url: "{{ route('register') }}",
            data: $('#loginForm').serialize(),
            success: (serverResponse) => { console.log(serverResponse);
                $('p.waiting').fadeOut();
                swal({
                    title: "¡Registro Completado!",
                    content: {
                        element: "p",
                        attributes: {
                        innerHTML: '<p class="swal-color">Su registro culminó con éxito, recuerde verificar su correo para poder disfrutar de nuestros servicios.</p>'
                        }
                    },
                    icon: "success",
                    button: "Aceptar",
                    className: "alert"
                }).then((value)=>{location.href='/'});
            },
            error: (serverResponse) => { console.log(serverResponse);
                if(serverResponse.status == 500){ 
                    $('p.waiting').fadeOut();
                    return displaySwal(''+
                    '<p class="swal-color" >Su registro se llevo a cabo. Pero hubo un error con su correo'
                    +', es posible que este no exista o no sea valido. Recuerde que para poder disfrutar'+
                    ' de nuestros servicios y re-establecer su contraseña si lo desea, debe verificar su correo.</p>');                 
                }
                
                $('p.waiting').fadeOut();
                let errors = '';
                let fields = [{name:'id_number_type', title: 'Tipo de identificación'},
                {name:'id_number', title:'Número de identificación'},
                {name:'name', title:'Nombre'}, {name:'lastname', title:'Apellido'},
                {name:'locality', title:'Ciudad'}, {name:'address', title:'Dirección'},
                {name:'phone_number', title:'Número de teléfono'}, 
                {name:'birth_date', title:'Fecha de nacimiento'},
                {name:'email', title:'Correo'}, 
                {name:'password', title:'Contraseña'}, 
                {name:'password_confirmation', title:'Confirmar contraseña'}];
                
                fields.forEach((field)=>{
                    errors+=process422Errors(serverResponse.responseJSON.errors[field.name], 
                    field.title);
                });
                $('p.waiting').fadeOut();
                displaySwal(errors);
            }//error
        })//ajax
});
</script> 
@endsection
