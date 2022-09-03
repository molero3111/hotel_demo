@extends('layouts.app')

@section('content')
<div class="container" id="table_container">
    <div class="row select-button-wrapper mx-auto ">
      <select class="custom-select mt-3 hotel-select">
        <option selected>Todas</option>
        <option>Pagadas</option>
        <option>En Espera</option>
      </select>
      <button type="button" class="reserve_hotel_button mt-3 btn open_people_modal btn-select"
     data-target="#add_new_person" >Reservar</button>
    </div>
    <div class="table-responsive-sm">
    <table class="table table-striped mt-3 text-center">
        <thead class="thad-dark">
          <tr>
            <th scope="col">Solicitada</th>
            <th scope="col">Check In</th>
            <th scope="col">Check Out</th>
            <th scope="col">Pago</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id='user_reservation_rows'>
        </tbody>
    </table>
    </div>
    <nav class="mt-3 mb-5 ">
        <ul class="pagination justify-content-center" id='pagination'>
          <li class="page-item page_navigation" id="previous_page" page='false'>
            <a class="page-link hotel-item" href="#" route='0'  aria-label="Previous">&laquo;</a>
          </li>
          {{-- user's reservations --}}
          <li class="page-item page_navigation" id="next_page"  page='false'>
            <a class="page-link hotel-item " href="#" aria-label="Next" route='0'>&raquo;</a>
          </li>
        </ul>
    </nav>
    
</div>{{--container--}}

{{-- reservation detail modal --}}
<!-- Modal -->
<div id="reservation_details" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">

    <!-- Modal content-->
    <div class="modal-content bg-transparent-black">
      <div class="modal-header">
        <h3 id="modal_title" class="modal-title form-text text-white">Detalles de Reserva</h3>
      </div>
      <div class="modal-body">
        <h4 class="modal-title form-text text-white text-center">Habitaciones</h4>
        <div id='rooms'>
          <div class="table-responsive-sm">
            <table class="table mt-3 table-borderless text-dark text-center hotel_table">
                <thead class="thad-dark">
                  <tr>
                    <th scope="col">Numero</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Precio</th>
                  </tr>
                </thead>
                <tbody id='reservation_room_rows'>
                </tbody>
            </table>
            </div>
        </div>
        <h4 class="modal-title form-text text-white text-center">Adultos</h4>
        <div id='adults'>
          <div class="table-responsive-sm">
            <table class="table mt-3 mb-3 table-borderless text-dark text-center hotel_table">
                <thead class="thad-dark">
                  <tr>
                    <th scope="col">Pasaporte</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Verificado/a</th>
                  </tr>
                </thead>
                <tbody id='reservation_people_rows'>
                </tbody>
            </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
        <button type="button" class="add_people hotel_button text-dark ">Continuar</button>
        </div>
    </div>
      
    </div>
  </div>
<script>

    var page_total, is_adult = 0, expected_items;

    function refreshReservationTable() {
      refreshTable({
        route: "{{route('reservations.index')}}", 
        entity:'reservations',
        populateTable: populateUserPeopleTable, 
        tbody_id:'#user_reservation_rows',
        no_row_message: 'No ha hecho ninguna reserva, por favor dirijase a la <a href="/home" >pagina principal</a> para hacer una reserva.'
      });
    }


    function populateUserPeopleTable(data, properties){ 
        let row_counter=0, table_rows='';

        $(properties.tbody_id + ' tr').each(function(){ $(this).remove(); });
          
        data.forEach((item)=>{
          row_counter++;
          table_rows= '<tr id="row'+item.id+'" class="w3-animate-zoom"><td>';
          table_rows+=item.created_at+ '</td>';
          table_rows+='<td>'+item.check_in + '</td>';
          table_rows+='<td>'+item.check_out+ '</td>';
          if(item.verified_at==null){ table_rows+='<td>En espera.</td>';}
          else{table_rows+='<td>'+item.verified_at+ '</td>';}   
          table_rows+='<td><a href="'+route_root+'reservations/'+item.id+'" target="_blank"><i class="fas fa-eye table-icon"></i></a></td>';
          table_rows+= '</tr>';
      
          $(properties.tbody_id).append(table_rows).hide().fadeIn();

          $('#show_reservati9on'+item.id).on('click', function (e) {
            console.log('id',e.target.id.replace('show_reservation',''));
            let id = e.target.id.replace('show_reservation','');
            $.ajax( {
              method: "GET",
              url: '/reservations/'+id,
              data: {page:properties.page},
              success: (serverResponse) => { 
                console.log(serverResponse);
                let reservation=serverResponse.reservation;
                let row;
                $('#reservation_people_rows tr').each(function(){$(this).remove(); });
                $('#reservation_room_rows tr').each(function(){$(this).remove(); });
                for (let i = 0; i < reservation.companions.length; i++) {
                  row='<tr>';
                  row+='<td>P - '+ reservation.companions[i].person.id_number +'</td>';
                  row+='<td>'+ reservation.companions[i].person.name + ' ' + reservation.companions[i].person.lastname +'</td>';
                  let verified_at='En Espera';
                  if(reservation.companions[i].pivot.verified_at!=null){
                    verified_at=reservation.companions[i].pivot.verified_at;
                  }
                  row+='<td>'+ verified_at +'</td>';
                  $('#reservation_people_rows').append(row).hide().fadeIn();
                }
                for (let i = 0; i < reservation.rooms.length; i++) {
                  row='<tr>';
                  row+='<td>'+ reservation.rooms[i].room_number +'</td>';
                  row+='<td>'+ reservation.rooms[i].type.type+'</td>';
                  row+='<td>$'+ reservation.rooms[i].type.price_per_day +'</td>';
                  $('#reservation_room_rows').append(row).hide().fadeIn();
                }
                $('#reservation_details').modal('show'); 
              },
              error: (serverResponse) => { console.log(serverResponse);
                displaySwal('Hubo un error con su petición, intente nuevamente.')
                .then((value)=>{location.href='/'});   }//error
              });
          });
        });

        for (let i = 0; i < (properties.per_page-row_counter); i++) {
            $(properties.tbody_id).
            append('<tr><td style="color:rgb(0,0,0,0);">none</td><td></td><td></td><td></td><td></td></tr>')
            .hide().fadeIn();
        }
        // event_properties.forEach((event)=>{ attachEvent(event); });

    }//populate function 

    //pagination

    refreshReservationTable();
    setNavBtnEvents({
      route: "{{route('reservations.index')}}", 
      entity:'reservations',
      populateTable: populateUserPeopleTable, 
      tbody_id:'#user_reservation_rows',
      next_page_id: '#next_page'
    });
</script>
@endsection