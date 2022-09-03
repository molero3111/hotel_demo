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
            <form action="/action_page.php" class="text-white carousel-form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="check_in">Check In:</label>
                        <input type="text" class="form-control hotel_input shadow datepicker"
                        id="check_in" placeholder="Ingrese fecha de llegada...">
                        <small id="checkInHelp" class="form-text text-white">Por favor,
                        ingrese la fecha de su llegada en formato día/mes/año.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="check_out">Check Out:</label>
                        <input type="text" class="form-control hotel_input shadow datepicker" 
                        id="check_out" placeholder="Ingrese fecha de salida...">
                        <small id="checkOutHelp" class="form-text text-white">Por favor,
                        ingrese la fecha de su salida en formato día/mes/año.</small>
                    </div>
                </div>
                <p  class="w3-animate-zoom waiting mt-3">
                    <i class="fa fa-spinner w3-spin "></i>
                </p>
                <button type="button" id='roomBtn' class="reservation_search_btn text-dark mt-3">Habitaciones</button>
            </form>
        </div>
    </div>
    <!--form-->
    <!-- features -->
    <div class="card-group mt-3">
        <div class="card ">
            <div class="card-body text-center">
                <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                    <div class="feature-text"><i class="fas fa-hotel"></i></div>
                    <div class=""><h2>Resort</h2></div>
                    <div class="text-justify">
                        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card ">
            <div class="card-body text-center">
                <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                    <div class="feature-text"><i class="fas fa-swimming-pool"></i></div>
                    <div class=""><h2>Piscina</h2></div>
                    <div class="text-justify">
                        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card ">
            <div class="card-body text-center">
                <div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
                    <div class="feature-text"><i class="fas fa-person-booth"></i></div>
                    <div class=""><h2>Habitaciones</h2></div>
                    <div class="text-justify">
                        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse nec faucibus velit. Quisque eleifend orci ipsum, a bibendum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!--features-->
    <!-- rooms -->
    <div id="room_display" class="carousel slide mt-3" data-ride="carousel">
        
        <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card-deck mx-2">
                    <div class="card bg-transparent-black shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title text-center text-hotel-orange">$100/Noche</h4>
                            <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                    <div class="card bg-transparent-black  shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                          <h4 class="card-title text-center text-hotel-orange">$100/Noche</h4>
                          <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                </div><!--card-deck-->
            </div><!--carousel-item-->
            <div class="carousel-item">
                <div class="card-deck mx-2">
                    <div class="card bg-transparent-black shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title text-center text-hotel-orange">$100/Noche</h4>
                            <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                    <div class="card bg-transparent-black  shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                          <h4 class="card-title text-center text-hotel-orange">$100/Noche</h4>
                          <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                </div><!--card-deck-->
            </div><!--carousel-item-->
            <div class="carousel-item">
                <div class="card-deck mx-2">
                    <div class="card bg-transparent-black shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                            <h4 class="card-title text-center text-hotel-orange">$100/Noche</h4>
                            <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                    <div class="card bg-transparent-black  shadow" >
                        <img class="card-img-top" src="images/carousel/hotel_room.jpg" alt="Card image">
                        <div class="card-body">
                          <h4 class="card-title text-center text-white">$100/Noche</h4>
                          <button class="room_btn text-dark">Ver Detalles</button>
                        </div>
                    </div>
                </div><!--card-deck-->
            </div><!--carousel-item-->
        </div>
        
        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#rooms" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#rooms" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
    </div>

    <!-- Room Modal -->
<div id="roomModal" class="modal fade modal-font-size" role="dialog">
    <div class="modal-dialog modal-lg  modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-body">
          <form action="#" method="POST" class="text-white w3-animate-zoom" id="roomForm">
            <h4 class="modal-title form-text text-center text-white mb-2">Habitaciones</h4>
                <div class="input-group mb-3">
                <select name="room" id="room" class="custom-select hotel_input shadow">
                    @for ($i = 0; $i < count($roomTypes); $i++)
                        <option>{{$roomTypes[$i]}}</option>
                    @endfor                         
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary inline_hotel_button text-dark" 
                    type="button" id="add_room"><i class="fas fa-plus"></i></button>
                </div>
                </div>
                <p class="text-center" id="no_rooms">No ha agregado ninguna habitación...</p>
                <div class="table-responsive-sm">
                <table class="table table-borderless text-dark text-center hotel_table" id="room_table">
                    <thead>
                      <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Capacidad</th>
                        <th scope="col">Precio/Noche</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody id="room_table_rows">
                    </tbody>
                </table>
                </div> {{--table-responsive--}}
                <hr/>
                <h4 class="modal-title form-text text-center text-white mb-2">Personas</h4>
                <div class="input-group mb-3">
                    <select name="person" id="person" 
                    class="custom-select hotel_input shadow">
                    </select>
                    <div class="input-group-append">
                        <button id="add_person" class="btn btn-outline-secondary inline_hotel_button text-dark" 
                        type="button" ><i id="add_person" class="fas fa-plus"></i></button>
                    </div>
                </div>
                <small id="personHelp" class="form-text text-white">Se muestran las personas
                que ha asociado con su perfil, si no aparece la persona que desea agregar, debe 
                dirigirse al modulo de acompañantes y agregar una nueva persona. 
                </small>
                <p class="text-center" id="no_people">No ha agregado ninguna persona...</p>
                <div class="table-responsive-sm">
                    <table class="table table-borderless text-dark text-center hotel_table" id="people_table">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Identificación</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody id="people_table_rows">
                        </tbody>
                    </table>
                </div> {{--table-responsive--}}
                <hr/>
                {{-- <h4 class="modal-title form-text text-center text-white mb-2">Menores de edad</h4>
                {{-- <label class="form-text" for="underage">Menores de edad:</label> 
                <div class="input-group mb-3">
                    <select name="underage" id="underage" 
                    class="custom-select hotel_input shadow">              
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary inline_hotel_button text-dark" 
                        type="button" id="add_underage"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <small id="underageHelp" class="form-text text-white">Se muestran los menores de
                edad que ha asociado con su perfil, si no aparece la persona que desea agregar, debe 
                dirigirse al modulo de acompañantes y agregar una nueva persona.
                </small>
                <p class="text-center" id="no_underages">No ha agregado ningún menor de edad...</p>
                <div class="table-responsive-sm">
                    <table class="table table-borderless text-dark text-center hotel_table" id="underage_table">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Identificación</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody id="underage_table_rows">
                        </tbody>
                    </table> 
                </div> table-responsive--}}
              </div>
              <input type="hidden" id="locality_token" name="locality_token" value='{{csrf_token()}}' />
              <p  class="w3-animate-zoom waiting mt-3">
                  <i class="fa fa-spinner w3-spin "></i>
              </p>
              <div class="modal-footer">
                <button type="button" id="reservationBtn" class="hotel_button text-dark ">Reservar</button>
                <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          </form>
        </div>
    </div>
    </div><!--Modal-->
    <script>
        var reservation = {rooms:[], companions:[]};

        $('#room_table').hide();
        $('#no_rooms').hide();

        $('#people_table').hide();
        $('#no_people').hide();


        function showTable(messageId, tableId, array) {
            if(array.length<1){
                $(messageId).fadeIn();
                $(tableId).fadeOut();
            }else {
                $(messageId).fadeOut();
                $(tableId).fadeIn();
            }
        }

        showTable('#no_people', '#people_table', reservation.companions);

        function addTableRow(properties, array) {

            showTable(properties.messageId, properties.tableId ,array)
            $(properties.tableBodyId).append(properties.row);
            $( properties.selectId+" option" ).each(function( index ) {
                if($( this ).text()==properties.selectedOption){ $( this ).remove();}
            });

        }

        function appendToSelect(people, selectId){

            if(people.length<1){
                $(selectId).append('<option>No tienes personas para agregar a la reserva.</option>');
            }

            people.forEach((person)=>{
                $(selectId).append('<option>'+person.name + ' ' + person.lastname + ', ' 
                + person.id_number_type.abbreviation + ' - ' + person.id_number+'</option>');
            });
        }

        function appendToSelectAfterDelete(properties){

            let option = '<option>'; 

                $( properties.tableRowId+" td" ).each(function( i ) {
                   
                    if(properties.isPersonData){  
                       
                        if(i==0){   option+=$( this ).text() + ', '; } 
                        else if (i==1) { option+=$( this ).text();}
                    }
                    else {  if(i==0){  option+=$( this ).text(); }   }
                });//each
                   
            option+='</option>';
            $(properties.selectId).prepend(option);       
        }

        function attachEvent(properties, array) {
            $(properties.tagId).on(properties.event, function(){  

                let id =  properties.tagId.replace(properties.stringToRemove, "");

                for (let i = 0; i < array.length; i++) {
                    if(array[i].id == id){
                        if(properties.option=='delete'){
                        array.splice(i, 1); 
                        appendToSelectAfterDelete({
                            selectId:properties.selectId, tableRowId: properties.tableRow,
                            isPersonData: properties.isPersonData
                        });
                        $(properties.tableRow).fadeOut().remove();
                        showTable(properties.messageId, properties.tableId, array);

                        
                        }//delete
                        else { array[i].amount=parseInt($(properties.tagId).val()); console.log(reservation)}
                    }//if(array.id == id){
                }//for
            });
        }


        function addPerson(properties, array) {

            let selectedOption=$(properties.selectId).val();
            let name=selectedOption.substr(0, (selectedOption.indexOf(',')));
            console.log(name);
            let id_number=selectedOption.substr((selectedOption.indexOf('-')-2), (selectedOption.length-1));
            console.log(id_number);
            let id=selectedOption.substr((selectedOption.indexOf('-')+2), (selectedOption.length-1));
            console.log(id);

            array.push({id:id});

            addTableRow({ 
                row:'<tr id="'+properties.newRowId+id+'"><td>'+name+'</td><td>'+ id_number +'</td><td><i id="delete_person'+id+'" class="fas fa-trash-alt table-icon"></i></td></tr>',
                messageId:properties.messageId, tableId:properties.tableId, tableBodyId: properties.tableBodyId, 
                selectId: properties.selectId, selectedOption: selectedOption
            }, array);
            attachEvent({
                tagId:'#delete_person'+id, event:'click', option:'delete',
                stringToRemove: '#delete_person', messageId:properties.messageId, tableId: properties.tableId,
                selectId:properties.selectId, tableRow: '#'+properties.newRowId+id, isPersonData:true
            }, array);

        }

        $('#roomBtn').on('click', function () {
        
            $('.waiting').fadeIn();

            $.ajax( {
            method: "GET",
            url: "{{route('related_people')}}",
            success: (serverResponse) => { console.log(serverResponse);
                $('.waiting').fadeOut();
                $('#roomModal').modal('show');
                showTable('#no_rooms', '#room_table', reservation.rooms);

                appendToSelect(serverResponse.companions, '#person');
                
            },
            error: (serverResponse) => { console.log(serverResponse);
                $('.waiting').fadeOut();
                
                let message ='<p class="swal-color" >Hubo un problema con su solicitud. Intente nuevamente.</p>';

                if(serverResponse.responseJSON.message=="Unauthenticated."){
                    message= '<p class="swal-color" >Para reservar, debe iniciar sesión primero.</p>';
                }

                if(serverResponse.responseJSON.message=="Your email address is not verified."){
                    
                    return location.href='/hotel/email/verify';
                }

                displaySwal(message);
                
                }//error
            });
        });

        //add room

        $('#add_room').on('click', function() {
            $('#room_wait').fadeIn();
            $.ajax( {
            method: "GET",
            url: "{{route('room_by_type')}}",
            data:{ type: $('#room').val()},
            success: (serverResponse) => { console.log(serverResponse);
                $('#room_wait').fadeOut();
                for(let i=0; i < reservation.rooms.length; i++){
                    if(reservation.rooms[i].id==serverResponse.id){
                        return displaySwal('<p class="swal-color" >El tipo de habitación que seleccionó, ya esta agregado a su solicitud de reserva. Si desea más habitaciones del mismo tipo, ingrese el número de habitaciones que desea en el campo cantidad correspondiente al tipo de habitación que desea.</p>');
                        break;
                    }
                }
                reservation.rooms.push({id:serverResponse.id, amount: 1});

                addTableRow({
                    row:'<tr id="room'+serverResponse.id+'" ><td>'+serverResponse.type+'</td><td>'+serverResponse.capacity+'</td><td>'+serverResponse.price_per_day+'</td><td><input id="room_amount'+serverResponse.id+'" class=" text-center col-4 hotel_input shadow room_amount" maxlength="2" type="text" value="1"></td><td><i id="delete_room'+serverResponse.id+'" class="fas fa-trash-alt table-icon"></i></td></tr>',
                    messageId:'#no_rooms', tableId:'#room_table', tableBodyId: '#room_table_rows', 
                    selectId: '#room', selectedOption: $('#room').val()
                }, reservation.rooms);

                attachEvent({
                    tagId:'#room_amount'+serverResponse.id, event:'keyup', option:'modify',
                    stringToRemove: '#room_amount', messageId:'#no_rooms', tableId:'#room_table'
                }, reservation.rooms);
                attachEvent({
                    tagId:'#delete_room'+serverResponse.id, event:'click', option:'delete',
                    stringToRemove: '#delete_room', messageId:'#no_rooms', tableId:'#room_table',
                    selectId:'#room', tableRow:'#room'+serverResponse.id, isPersonData:false
                }, reservation.rooms);
            },
            error: (serverResponse) => { console.log(serverResponse);
                $('#room_wait').fadeOut();
                var errors='';
                errors += process422Errors(serverResponse.responseJSON.errors.type,
                'Tipo de habitación');
                displaySwal(errors);
                
                }//error
            });
            
        });

         //add person
         $('#add_person').on('click', function () {
            addPerson({
                selectId: '#person', newRowId: 'person', messageId: '#no_people',
                tableId: '#people_table', tableBodyId: '#people_table_rows'
            },reservation.companions);
           
        });

        $('#reservationBtn').on('click', function () {
            $('.waiting').fadeIn();
            reservation.check_in=$('#check_in').val();
            reservation.check_out=$('#check_out').val();
            reservation_data = JSON.stringify(reservation);
            $.ajax( {
            method: "POST",
            url: "{{route('reservations.store')}}",
            data:{ reservation_data: reservation_data, _token:'{{csrf_token()}}'},
            success: (serverResponse) => { console.log(serverResponse);
                $('.waiting').fadeOut();

                if(serverResponse.success){
                    displaySwal(
                        serverResponse.message,
                        {title:'Reserva Completada.', icon:'success'}
                    );
                } else {  displaySwal(serverResponse.message );}
               
            },
            error: (serverResponse) => { console.log(serverResponse);
                $('.waiting').fadeOut();
                displaySwal('Hubo un problema con su petición.' );
                
                }//error
            });
        });

        /////flash messages

        @if(Session::has('error_message'))
            displaySwal('{{ Session::get('error_message') }}');
        @endif

        @if(Session::has('message'))
            displaySwal('{{ Session::get('message') }}',
            {title:'Perfil Asociado', icon:'success'});
        @endif
</script>
@endsection
