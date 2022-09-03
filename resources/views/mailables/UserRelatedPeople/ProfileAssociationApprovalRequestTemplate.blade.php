@extends('layouts.mail')

@section('content')
{{--<div class="container text-center">
    <h3 class="mt-5 mb-3">Hola {{$requested->name}}.</h3>
    <p class="mb-5">El usuario {{$requester->name}} {{$requester->lastname}} solicitó asociarte  
    a su perfil como su {{$relation_type}}, para poder registrarte en sus futuras reservas de nuestro hotel, si estas de acuerdo
    haz click en aprobar, o copia y pega este link en tu navegardor: 
    {{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=1</p>

    <a href="{{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=1"  target="_blank"
    class="hotel_button text-dark link-button mt-3 mb-3">Aprobar</a>

    <p class="mb-5">Para rechazar esta solicitud puede hacer click 
        <a href='{{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=0' target="blank">aquí</a>
    o copiar y pegar este link en 
    navegador: {{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=0. tenga en cuenta que al rechazar esta solicitud la persona que solicitó asociarte
    a su perfil no podrá intentarlo nuevamente, a menos de que usted ingrese su número de pasaporte 
    luego de hacer click en el botón desbloquear, que se muestra en la opción de personas.
    Este botón solo se habilita si ha rechazado al menos una solicitud de este tipo.
    por lo que no debe preocuparse si aparece desahabilitado por los momentos.
    </p>
    
</div>--}}
<div class="container text-center">
    <h3 class="mt-5 mb-3">Hola {{$requested->name}}.</h3>
    <p class="mb-5">El usuario {{$requester->name}} {{$requester->lastname}} te asocio  
    a su perfil como su {{$relation_type}}, para poder registrarte en sus futuras reservas de nuestro hotel.</p>

    <p class="mb-5">Para rechazar esta solicitud puede hacer click 
    <a href='{{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=0' target="blank">aquí</a>
    o copiar y pegar este link en 
    navegador: {{route('user_profile_association')}}?t={{$token}}&c={{$companion_id}}&a=0. tenga en cuenta que al rechazar esta solicitud la persona que te asocio
    a su perfil no podrá intentarlo nuevamente, a menos de que usted ingrese su número de identificacion 
    luego de hacer click en el botón desbloquear, que se muestra en la opción de personas.
    Este botón solo se habilita si ha rechazado al menos una solicitud de este tipo.
    por lo que no debe preocuparse si aparece desahabilitado o no se muestra por los momentos.
    </p>
    
</div>


@endsection