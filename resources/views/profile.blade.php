@extends('layouts.app')

@section('content')

<div class="container profile-text">
    <h2 class="form-text text-center mt-4 mb-3"><i class="fas fa-user"></i> Perfil</h2>
    <div class="row responsive-width">
        <div class="col-md-6">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="idNumberDisplay">
                        <span class="text-bold">Identificación:</span>
                         {{$user['person']['id_number_type']['abbreviation']}}-{{$user['person']['id_number']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="id_number_modal_display" id_number_type='{{$user['person']['id_number_type']['abbreviation']}}'
                    id_number='{{$user['person']['id_number']}}'
                    data-toggle="modal" data-target="#updateIdNumberModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    </div>{{--row --}}
    <div class="row responsive-width">
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="nameDisplay">
                        <span class="text-bold">Nombre:</span>
                         {{$user['person']['name']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Nombre" fieldName='name' name='{{$user['person']['name']}}'
                    data-toggle="modal" data-target="#updateProfileModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="lastnameDisplay">
                        <span class="text-bold">Apellido:</span>
                         {{$user['person']['lastname']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Apellido" fieldName='lastname' name='{{$user['person']['lastname']}}'
                    data-toggle="modal" data-target="#updateProfileModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    </div> {{--row --}}
    <hr/>
    <div class="row responsive-width">
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="localityDisplay">
                        <span class="text-bold">Ciudad:</span>
                         {{$user['person']['locality']['name']}},
                         {{$user['person']['locality']['region']['name']}},
                         {{$user['person']['locality']['region']['country']['name']}}.
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Ciudad" fieldName='locality' name='{{$user['person']['locality']['name']}}'
                    data-toggle="modal" data-target="#updateLocalityModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    {{--</div> --}}{{--row --}}
    {{-- <div class="row responsive-width"> --}}
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="addressDisplay">
                        <span class="text-bold">Dirección:</span>
                         {{$user['person']['address']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Dirección" fieldName='address' name='{{$user['person']['address']}}'
                    data-toggle="modal" data-target="#updateProfileModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    </div> {{--row--}}
    <div class="row responsive-width">
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="phone_numberDisplay">
                        <span class="text-bold">Teléfono:</span>
                         {{$user['person']['phone_number']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Teléfono" fieldName='phone_number' name='{{$user['person']['phone_number']}}'
                    data-toggle="modal" data-target="#updateProfileModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="birthDateDisplay">
                        <span class="text-bold">Fecha de nacimiento:</span>
                        {{$user['person']['birth_date']->format('d-m-Y')}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="birth_date" fieldName='birth_date' name='{{$user['person']['birth_date']->format('d-m-Y')}}'
                    data-toggle="modal" data-target="#updateBirthDateModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    </div> {{--row --}}
    <hr/>
    <div class="row responsive-width">
        <div class="col-md-6 mt-2 mb-3">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark" id="emailDisplay">
                        <span class="text-bold">Correo:</span>
                         {{$user['email']}}
                    </span> 
                </div>
                <div class="col-2">
                    <i id="Correo" fieldName='email' name='{{$user['email']}}'
                    data-toggle="modal" data-target="#updateProfileModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="row">
                <div class="col-10">
                    <span class="hotel-text-dark">
                        <span class="text-bold">Contraseña:</span>
                         *******
                    </span> 
                </div>
                <div class="col-2">
                    <i   data-toggle="modal" data-target="#updatePasswordModal" 
                    class="edit mr-3 text-bold fas fa-edit "></i>
                </div>
            </div>
        </div>
    </div>{{--row --}}
</div> {{-- container        --}}

<!-- Modal -->
<div id="updateProfileModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content bg-transparent-black">
      <div class="modal-header">
        <h4 id="modalTitle" class="modal-title form-text text-white">Editar</h4>
      </div>
      <div class="modal-body">
        <form action="{{route('updateProfile')}}" method="POST" class="text-white w3-animate-zoom" id="updateProfileForm">
            <div class="form-group ">
                <label id='modalFormLabel' class="form-text" for="fieldValue"></label>
                <input type="text" class="form-control hotel_input shadow"
                id="fieldValue" maxlength="200"
                name="fieldValue" required autocomplete="" autofocus>
                <small id="formHelp" class="form-text text-white">Para modificar, 
                edite el campo de texto y haga click en actualizar. haga click en cerrar si no 
                desea actualizar su información.
                </small>
                <label class="form-text" for="user_password">Contraseña:</label>
                <input type="password" class="form-control hotel_input shadow"
                    id="user_password" placeholder="Ingrese su contraseña..."
                    name="user_password" required>
                    <small id="formHelp" class="form-text text-white">Para poder modificar, 
                    debe ingresar su contraseña nuevamente.
                    </small>
            </div>
            <input type="hidden" id="fieldName" name="fieldName" />
            <input type="hidden" id="_token" name="_token" value='{{csrf_token()}}' />
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" id="updateProfileBtn" class="hotel_button text-dark ">Actualizar</button>
            <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
        </div>
        </form>
    </div>
      
    </div>
  </div>
  <!-- birth_date Modal -->
<div id="updateBirthDateModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-header">
          <h4 id="modalTitle" class="modal-title form-text text-white">Editar</h4>
        </div>
        <div class="modal-body">
          <form action="{{route('updateProfile')}}" method="POST" 
          class="text-white w3-animate-zoom" id="updateBirthDateForm">
              <div class="form-group ">
                  <label id='modalFormLabel' class="form-text" for="birth_date_input"></label>
                  <input type="text" class="form-control hotel_input shadow"
                  id="birth_date_input" maxlength="200"
                  name="birth_date_input" required autocomplete="" autofocus>
                  <small id="formHelp" class="form-text text-white">Para modificar, 
                  edite el campo de texto y haga click en actualizar. haga click en cerrar si no 
                  desea actualizar su información.
                  </small>
                  <label class="form-text" for="birth_date_password">Contraseña:</label>
                  <input type="password" class="form-control hotel_input shadow"
                      id="birth_date_password" placeholder="Ingrese su contraseña..."
                      name="birth_date_password" required>
                      <small id="formHelp" class="form-text text-white">Para poder modificar, 
                      debe ingresar su contraseña nuevamente.
                      </small>
              </div>
              <input type="hidden" id="birth_date_token" name="_token" value='{{csrf_token()}}' />
              <p  class="w3-animate-zoom waiting mt-3">
                  <i class="fa fa-spinner w3-spin "></i>
              </p>
          </div>
          <div class="modal-footer">
              <button type="button" id="updateBirthDateBtn" class="hotel_button text-dark ">Actualizar</button>
              <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
          </div>
          </form>
      </div>
        
      </div>
    </div>
<!-- id number Modal -->
<div id="updateIdNumberModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-header">
          <h4 id="modalTitle" class="modal-title form-text text-white">Editar número de identificación:</h4>
        </div>
        <div class="modal-body">
          <form action="{{route('updateProfile')}}" method="POST" class="text-white w3-animate-zoom" id="updateIdNumberForm">
            <label id='modalFormLabel' class="form-text" for="id_number_type">Número de identificación:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <select id="id_number_type" name="id_number_type"
                    class="custom-select hotel_input shadow">
                    <option selected>{{$idNumberTypes[0]['abbreviation']}}</option>
                    @for ($i = 1; $i < count($idNumberTypes); $i++)
                        <option>{{$idNumberTypes[$i]['abbreviation']}}</option>
                    @endfor                       
                    </select>  
                </div>
                <input type="text" id="id_number" name="id_number" class="form-control  hotel_input shadow" 
                placeholder="Ingrese su número de identificación..." max="20">
                <small id="formHelp" class="form-text text-white">Para modificar, 
                edite el campo de texto y haga click en actualizar. haga click en cerrar si no 
                desea actualizar su información.
                </small>
            </div>    
            <div class="form-group">
                  <label class="form-text" for="password">Contraseña:</label>
                  <input type="password" class="form-control hotel_input shadow"
                      id="password" placeholder="Ingrese su contraseña..."
                      name="password" required>
                      <small id="formHelp" class="form-text text-white">Para poder modificar, 
                      debe ingresar su contraseña nuevamente.
                      </small>
              </div>
              <input type="hidden" id="id_number_token" name="id_number_token" value='{{csrf_token()}}' />
              <p  class="w3-animate-zoom waiting mt-3">
                  <i class="fa fa-spinner w3-spin "></i>
              </p>
          </div>
          <div class="modal-footer">
              <button type="button" id="updateIdNumberBtn" class="hotel_button text-dark ">Actualizar</button>
              <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
          </div>
          </form>
      </div>
        
      </div>
    </div>
<!-- update locality Modal -->
<div id="updateLocalityModal" class="modal fade " role="dialog">
    <div class="modal-dialog  modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-header">
          <h4 class="modal-title form-text text-white">Editar ciudad</h4>
        </div>
        <div class="modal-body">
          <form action="{{route('updateProfile')}}" method="POST" class="text-white w3-animate-zoom" id="updateLocalityForm">
              {{-- <div class="form-group form-element-width"> --}}
                {{-- <div id="countryForm" class="form-group mb-3 form-element-width col-sm-6"> --}}
                    <label class="form-text" for="country">País:</label>
                    <select name="country" id="country" class="custom-select hotel_input shadow">
                        <option selected>Seleccione País</option>
                        @for ($i = 0; $i < count($countries); $i++)
                            <option>{{$countries[$i]['name']}}</option>
                        @endfor                        
                    </select>
                {{-- </div> --}}
                {{-- <div id="regionForm"  class="form-group mb-3 form-element-width col-sm-6"> --}}
                    <label class="form-text" for="country">Estado:</label>
                    <select name="region" id="region" disabled
                    class="custom-select hotel_input shadow">
                        <option>Seleccione estado...</option>
                    </select>
                {{-- </div> --}}
                {{-- </div> --}}
                {{-- <div class="row"> --}}
                {{-- <div id="localityForm"  class="form-group mb-3  col-sm-6"> --}}
                    <label class="form-text" for="locality">Ciudad:</label>
                    <select name="locality" id="locality" disabled
                    class="custom-select hotel_input shadow">
                        <option>Seleccione ciudad...</option>                 
                    </select>
                {{-- </div> --}}
                    <label class="form-text" for="locality_modal_password">Contraseña:</label>
                    <input type="password" class="form-control hotel_input shadow"
                    id="locality_modal_password" placeholder="Ingrese su contraseña..."
                    name="locality_modal_password" required>
                    <small id="formHelp" class="form-text text-white">Para poder modificar, 
                    debe ingresar su contraseña nuevamente.
                    </small>
              </div>
              <input type="hidden" id="locality_token" name="locality_token" value='{{csrf_token()}}' />
              <p  class="w3-animate-zoom waiting mt-3">
                  <i class="fa fa-spinner w3-spin "></i>
              </p>
              <div class="modal-footer">
                <button type="button" id="updateLocalityBtn" class="hotel_button text-dark ">Actualizar</button>
                <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          </form>
      </div>
      </div>
    </div>
<!-- password Modal -->
<div id="updatePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-header">
          <h4 class="modal-title form-text text-white">Editar contraseña</h4>
        </div>
        <div class="modal-body">
          <form action="{{route('updateProfile')}}" method="POST" class="text-white w3-animate-zoom" id="updatePasswordForm">
              <div class="form-group form-element-width">
                    <label class="form-text" for="new_password">Contraseña nueva:</label>
                    <input type="password" class="form-control hotel_input shadow"
                    id="new_password" maxlength="50"
                    name="new_password" required autocomplete="" autofocus>
                    <label class="form-text" for="password_confirm">Confirmar contraseña:</label>
                    <input type="password" class="form-control hotel_input shadow"
                    id="password_confirm" maxlength="50"
                    name="password_confirm" required autocomplete="" autofocus>
                    <hr/>
                    <label class="form-text" for="current_password">Contraseña actual:</label>
                    <input type="password" class="form-control hotel_input shadow"
                    id="current_password" placeholder="Ingrese su contraseña..."
                    name="current_password" required>
                    <small id="formHelp" class="form-text text-white">Para poder modificar, 
                    debe ingresar su contraseña actual nuevamente.
                    </small>
              </div>
              <input type="hidden" id="password_token" name="password_token" value='{{csrf_token()}}' />
              <p  class="w3-animate-zoom waiting mt-3">
                  <i class="fa fa-spinner w3-spin "></i>
              </p>
          </div>
          <div class="modal-footer">
              <button type="button" id="updatePasswordBtn" class="hotel_button text-dark ">Actualizar</button>
              <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
          </div>
          </form>
      </div>
        
      </div>
    </div>
<script>
attachDatePicker('#birth_date_input',$('#birth_date').attr('name'));

let fieldContent,fieldNameDisplay, idToModify, iconToModify;
$('.edit').on('click', function (e) {
    $('#modalTitle').html('Editar ' + e.target.id+ ':');
    $('#modalFormLabel').html(e.target.id + ':');
    $('#fieldValue').val(e.target.getAttribute('name'));
    $('input#fieldName').val(e.target.getAttribute('fieldName'));
    $('#user_password').val('');

    fieldNameDisplay = '<span class="text-bold">'+e.target.id+':</span> ';
    idToModify = e.target.getAttribute('fieldName')+'Display';
    iconToModify = e.target.id;
});

$('#updateProfileBtn').on('click',function () {
$('.waiting').fadeIn();
fieldContent= fieldNameDisplay + $('#fieldValue').val();
$.ajax( {
    method: "POST",
    url: "{{route('updateProfile')}}",
    data:$('#updateProfileForm').serialize(),
    success: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.icon == 'warning'){
            return swal(serverResponse);
        }
        $('#updateProfileModal').modal('hide');
        $('#'+idToModify).html(fieldContent);
        $('#'+iconToModify).attr('name', $('#fieldValue').val());
        swal(serverResponse);
    },
    error: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        var errors='';
        errors += process422Errors(serverResponse.responseJSON.errors.fieldValue, 
        iconToModify);
        displaySwal(errors);
        
        }//error
    });
});

//update id number 

$('#id_number_modal_display').on('click',function(e){

    $('#id_number').val(e.target.getAttribute('id_number'));
    let options=$('#id_number_type option');
    for(let i=0; i<options.length; i++){
        if(options[i].value == e.target.getAttribute('id_number_type')){
            $("#id_number_type").val(options[i].value).change();
            break;
        }
    }
});

$('#updateBirthDateBtn').on('click',function () {
$('.waiting').fadeIn();
$.ajax( {
    method: "POST",
    url: "{{route('updateProfile')}}",
    data:{
        fieldName:'birth_date',
        fieldValue: $('#birth_date_input').val(),
        user_password: $('#birth_date_password').val(),
        _token:$('#birth_date_token').val()
    },
    success: (serverResponse) => { //console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.icon == 'warning'){
            return swal(serverResponse);
        }
        $('#updateBirthDateModal').modal('hide');
        $('#birthDateDisplay').html('<span class="text-bold">Fecha de nacimiento:</span> '+  $('#birth_date_input').val());
        $('#birth_date').attr('name', $('#birth_date_input').val());
        swal(serverResponse);
    },
    error: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        var errors='';
        errors += process422Errors(serverResponse.responseJSON.errors.fieldValue, 
        'Fecha de nacimiento');
        displaySwal(errors);
        
        }//error
    });
});

$('#updateIdNumberBtn').on('click',function () {
$('.waiting').fadeIn();
$.ajax( {
    method: "POST",
    url: "{{route('updateProfile')}}",
    data:{
        fieldName:'id_number',
        fieldValue: $('#id_number').val(),
        id_number_type: $('#id_number_type').val(),
        user_password: $('#password').val(),
        _token:'{{csrf_token()}}'
    },
    success: (serverResponse) => { //console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.icon == 'warning'){
            return swal(serverResponse);
        }
        $('#updateIdNumberModal').modal('hide');
        $('#idNumberDisplay').html('<span class="text-bold">Identificación:</span> '+ $('#id_number_type').val() + '-'+$('#id_number').val());
        $('#id_number_modal_display').attr('id_number', $('#id_number').val());
        $('#id_number_modal_display').attr('id_number_type', $('#id_number_type').val());
        swal(serverResponse);
    },
    error: (serverResponse) => { //console.log(serverResponse);
        $('.waiting').fadeOut();
        var errors='';
        errors += process422Errors(serverResponse.responseJSON.errors.id_number_type, 
        'Tipo de identificación');
        errors += process422Errors(serverResponse.responseJSON.errors.fieldValue,
        'Número de identicación');
        displaySwal(errors);
        
        }//error
    });
});

//Events for populating the country select fields, populateCountryFields is in hotel_functions.js file
populateCountryFields([
    {tagId:'country', _token:'{{csrf_token()}}', route:"{{ route('regions') }}",
     fieldName:'País', parentSelectId:'country', childSelectId:'region'},

     {tagId:'region', _token:'{{csrf_token()}}', route:"{{ route('localities') }}",
     fieldName:'Estado', parentSelectId:'region', childSelectId:'locality'},
]);

$('#updateLocalityBtn').on('click',function () {
$('.waiting').fadeIn();
$.ajax( {
    method: "POST",
    url: "{{route('updateProfile')}}",
    data:{
        fieldName:'locality_id',
        fieldValue: $('#locality').val(),
        user_password: $('#locality_modal_password').val(),
        _token:$('#locality_token').val()
    },
    success: (serverResponse) => { //console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.icon == 'warning'){
            return swal(serverResponse);
        }
        $('#updateLocalityModal').modal('hide');
        $('#localityDisplay').html('<span class="text-bold">Ciudad:</span> '+ $('#locality').val() 
        + ', '+$('#region').val() + ', '+$('#country').val()+'.' );
        swal(serverResponse);
    },
    error: (serverResponse) => { //console.log(serverResponse);
        $('.waiting').fadeOut();
        var errors='';
        errors += process422Errors(serverResponse.responseJSON.errors.fieldValue,
        'Ciudad');
        displaySwal(errors);
        
        }//error
    });
});

//PASSWORD UPDATE
$('#updatePasswordBtn').on('click',function () {
$('.waiting').fadeIn();
$.ajax( {
    method: "POST",
    url: "{{route('updateProfile')}}",
    data:{
        fieldName:'password',
        fieldValue: $('#new_password').val(),
        fieldValue_confirmation: $('#password_confirm').val(),
        user_password: $('#current_password').val(),
        _token:$('#password_token').val()
    },
    success: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.icon == 'warning'){
            return swal(serverResponse);
        }
        $('#updatePasswordModal').modal('hide');
        swal(serverResponse);
    },
    error: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        var errors='';
        errors += process422Errors(serverResponse.responseJSON.errors.fieldValue,
        'Contraseña');
        displaySwal(errors);
        
        }//error
    });
});
</script>
@endsection