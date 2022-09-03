@extends('layouts.app')

@section('content')
<div id="no_records message."></div>
<div class="container" id="table_container">
    <div class="row select-button-wrapper mx-auto ">
      {{-- <select class="custom-select mt-3 hotel-select" id='people_type_select'>
        <option selected>Adultos</option>
        <option>Menores de edad</option>
      </select> --}}
      <button type="button" id="insert_person_btn" class=" mx-auto reserve_hotel_button mt-3 btn open_people_modal btn-select"
      data-toggle="modal" data-target="#person_modal" >Agregar Persona</button>
    </div>
    <div class="table-responsive-sm">
    <table class="table table-striped mt-3 text-center">
        <thead class="thad-dark">
          <tr>
            <th scope="col">Indentificación</th>
            <th scope="col">Nombre</th>
            <th scope="col">Relación</th>
            <th scope="col">Agregado/a</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id='user_people_rows'>
        </tbody>
    </table>
    </div>
    <nav class="mt-3 mb-5 ">
        <ul class="pagination justify-content-center" id='adult_pagination'>
          <li class="page-item page_navigation" id="previous_page" page='false'>
            <a class="page-link hotel-item" href="#" route='0' name='1' aria-label="Previous">&laquo;</a>
          </li>
          {{-- user's people --}}
          <li class="page-item page_navigation" id="next_page"  page='false'>
            <a class="page-link hotel-item " href="#" aria-label="Next" route='0' name='2'>&raquo;</a>
          </li>
        </ul>
    </nav>
    
</div>{{--container--}}

<div class="w-75"><a href="#" id='unblock' style="display:none;"  data-toggle="modal" 
data-target="#person_modal" class="hotel-text-dark small-text text-center open_people_modal">
Desbloquear</a></div>
{{-- add new person modal --}}
<!-- Modal -->
<div id="person_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content bg-transparent-black">
      <div class="modal-header">
        <h4 id="modal_title" class="modal-title form-text text-white">Agregar </h4>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" class="text-white w3-animate-zoom" id="userPeopleForm">
          <small class="form-text text-white ">Número de identificación:</small>
            <div class="input-group">
              <div class="input-group-prepend">
                <select id="id_number_type" name="id_number_type"
                class="custom-select hotel_input shadow">
                  <option selected>{{$id_number_types[0]->abbreviation}}</option>
                  @for ($i = 1; $i < count($id_number_types); $i++)
                    <option>{{$id_number_types[$i]->abbreviation}}</option>
                  @endfor                        
                </select>  
              </div>
              <input type="text" id="id_number" name="id_number" class="form-control hotel_input shadow" 
              placeholder="Ingrese número de identificación...">
            </div>
            <div class="form-group ">
              <small class="form-text text-white">Nombre:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="name" maxlength="40" name="name" required 
              placeholder="Ingrese nombre..."
              autocomplete="" autofocus />
            </div>
            <div class="form-group ">
              <small class="form-text text-white">Apellido:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="lastname" maxlength="40" name="lastname" required 
              placeholder="Ingrese apellido..."
              autocomplete="" autofocus />
            </div>
            <div class="form-group ">
              <small class="form-text text-white">Télefono:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="phone_number" maxlength="25" name="phone_number" 
              placeholder="Ingrese número de télefono..."
              autocomplete="" autofocus />
            </div>
            <div class="form-group ">
              <small class="form-text text-white">Correo:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="email" maxlength="80" name="email" 
              placeholder="Ingrese correo..."
              autocomplete="" autofocus />
            </div>
            <div class="form-group ">
              <small class="form-text text-white">Dirección:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="address" maxlength="150" name="address" 
              placeholder="Ingrese dirección..."
              autocomplete="" autofocus />
            </div>
            <div class="form-group ">
              <small id="form_help" class="form-text text-white">Fecha de nacimiento:</small>
              <input type="text" class="form-control hotel_input shadow"
              id="birth_date" maxlength="200" name="birth_date" required 
              placeholder="Ingrese fecha de nacimiento..."
              autocomplete="" autofocus />
            </div>
            <div id="relationship">
            <label class="form-text" for="relation_type">Parentesco:</label>
            <select name="relation_type" id="relation_type" 
            class="custom-select hotel_input shadow">
              @for ($i = 0; $i < count($relation_types); $i++)
                <option>{{$relation_types[$i]['type']}}</option>
              @endfor 
            </select>
            </div>
            @csrf 
            <p  class="w3-animate-zoom waiting mt-3">
                <i class="fa fa-spinner w3-spin "></i>
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
          <button type="button" class="add_people hotel_button text-dark ">Continuar</button>
         </div>
        </form>
    </div>
      
    </div>
  </div>
<script>

  attachDatePicker('#birth_date', getCurrentDate());

  var route={ path:"{{route('user_companions.store')}}", verb:'POST' }

    var page_total, is_adult = 0, expected_items;

    // function setPeopleModal(e) {

    //   modal_properties=['Inserte el número de pasaporte de la persona a agregar.',
    //   'Inserte el número de pasaporte de la persona a desbloquear.'
    //   ]
      
    //   if(e.target.id=='open_adult_modal'){ 
    //     $('#modal_title').text('Agregar adulto');
    //     $('#form_help').text(modal_properties[0]); is_adult=1;
    //     $('#relationship').show();
    //   }
    //   else if(e.target.id=='unblock'){
    //     $('#modal_title').text('Desbloquear Persona');
    //     $('#form_help').text(modal_properties[1]);
    //     $('#relationship').hide();
    //   }
    //   else { 
    //     $('#modal_title').text('Agregar menor de edad');
    //     $('#form_help').text(modal_properties[0]);
    //     $('#relationship').show();
    //   }

    // }
    function refreshPeopleTable(modal_id) {
      refreshTable({
        route: "{{route('adults.index')}}", 
        entity:'related_people',
        populateTable: populateUserPeopleTable, 
        tbody_id:'#user_people_rows',
        next_page_id: '#next_page',
        modal_id: modal_id,
        no_row_message: 'No tiene personas agregadas, puede agregar una persona haciendo click en el boton agregar persona.'
      });
    }

    function setUserPersonForm(params) {

      var inputs = ['name', 'lastname', 'id_number', 'address',
      'phone_number', 'email', 'birth_date'];
      select_ids = [['id_number_type', 'abbreviation'], ['relation_type', 'type']];
      var selects = [ $('#id_number_type option'), $('#relation_type option') ];

      if(params.insert){
        inputs.forEach((input)=> { $('#'+input).val(''); });
        for (let i = 0; i < selects.length; i++) {
          selects[i][0].selected=true; 
        }
      }
      else {
        inputs.forEach((input)=> { $('#'+input).val(params['person']['companion'][input]); });
        var i = 0;
        selects.forEach((options)=> {
          for (let j = 0; j < options.length; j++) {
            if(options[j].value == params['person'][select_ids[i][0]][select_ids[i][1]])
            { options[j].selected=true; }
          }
          i++;
        });
      }
    }

    event_properties = [
          // {tag:'.resend_mail', event:'click', 
          // action: function (e) {
          //   $('#process_icon').fadeIn();
          //   $.ajax( {
          //     method: "GET",
          //     url: "{{route('resendAssociationApprovalRequest')}}",
          //     data: {
          //       i: e.target.id.replace('resend_mail','')
          //     },
          //     success: (serverResponse) => { console.log(serverResponse);
          //       $('#process_icon').fadeOut().hide();
          //         if(serverResponse.success){
          //           displaySwal(serverResponse.message, {
          //             title:'Solicitud enviada',
          //             icon:'success'
          //           });
          //         }else {
          //           displaySwal(serverResponse.message);
          //         }
          //     },
          //     error: (serverResponse) => { console.log(serverResponse);  $('#process_icon').fadeOut().hide();
          //       displaySwal('Hubo un error con su petición, intente nuevamente.');   }//error
          //   });//ajax
          //   }//action function
          //   }//event object
           // ,
            {tag:'.delete_person', event:'click', 
            action: function (e) { console.log('deleting...');
            $('#process_icon').fadeIn();
            let id=e.target.id.replace('remove_person','');
              displaySwal('¿Seguro que deseas eliminar esta persona?', false, true)
              .then((value)=>{
                if(value){
                  $.ajax( {
                    method: "DELETE",
                    url: route_root+'user_companions/'+id,
                    data:{ _token: "{{ csrf_token() }}" },
                    success: (serverResponse) => { console.log(serverResponse);
                      $('#process_icon').fadeOut().hide();
                        if(serverResponse.success){
                          // $('#row'+id).remove();
                          displaySwal(serverResponse.message, {
                            title:'Persona eliminada exitosamente',
                            icon:'success'
                          }).then((value)=>{refreshPeopleTable()});
                        }else {
                          displaySwal(serverResponse.message);
                        }
                    },
                    error: (serverResponse) => { console.log(serverResponse); $('#process_icon').fadeOut().hide();
                      displaySwal('Hubo un error con su petición, intente nuevamente.');   }//error
                  });//ajax
                }
              });
              
              }
            },
            {tag:'.update', event:'click', 
              action: function(e) { 
                $('#process_icon').fadeIn();
                $('#modal_title').text('Actualizar persona');
                let id=e.target.id.replace('edit','');
                route={ path:(route_root+"user_companions/"+id), verb:'PUT' }
                $.ajax( {
                  method: "GET",
                  url: route_root+'user_companions/'+id,
                  success: (serverResponse) => {  console.log(serverResponse);
                    $('#process_icon').fadeOut().hide();
                      if(serverResponse.message){ console.log(serverResponse); displaySwal(serverResponse.message);}
                      else { 
                        setUserPersonForm({
                          insert: false,
                          person: serverResponse
                        }); 
                      }
                  },
                  error: (serverResponse) => { console.log(serverResponse); $('#process_icon').fadeOut().hide();
                  displaySwal('Hubo un error con su petición, intente nuevamente.');   }//error
                  
                });
              }
            }              
              //   });//ajax
              // }
            
            
            // {tag:'.relationships', event:'change', 
            // action: function (e) { console.log('updating...'); 
            // $('#process_icon').fadeIn();
            //   displaySwal('¿Seguro que deseas actualizar el tipo de relación a '+e.target.value+'?', false, true)
            //   .then((value)=>{
            //     if(value){
            //       $.ajax( {
            //         method: "PUT",
            //         url: e.target.getAttribute('route'),
            //         data:{ _token: "{{ csrf_token() }}", relationship:e.target.value },
            //         success: (serverResponse) => {  console.log(serverResponse);
            //           $('#process_icon').fadeOut().hide();
            //             if(serverResponse.success){
            //               displaySwal(serverResponse.message, {
            //                 title:'Tipo de relación actualizado.',
            //                 icon:'success'
            //               }).then((value)=>{
            //                 // if(serverResponse.route_entity=='adults'){refreshPeopleTable();}
            //                 // else  {
            //                 //         refreshTable({
            //                 //           route: "{{route('underages.index')}}", 
            //                 //           entity:'related_people',
            //                 //           populateTable: populateUserPeopleTable, 
            //                 //           tbody_id:'#user_people_rows',
            //                 //           next_page_id: '#next_page',
            //                 //           modal_id: modal_id
            //                 //         });
            //                 //       }
            //               });
            //             }else {
            //               console.log(serverResponse);
            //               displaySwal(serverResponse.message);
            //             }
            //         },
            //         error: (serverResponse) => { console.log(serverResponse); $('#process_icon').fadeOut().hide();
            //           displaySwal('Hubo un error con su petición, intente nuevamente.');   }//error
            //       });//ajax
            //     }
            //   });
              
            //   }
            // }
        ];

    function populateUserPeopleTable(data, properties){ 
        let row_counter=0, table_rows='';

        $(properties.tbody_id + ' tr').each(function(){
          $(this).remove();
        });
          
        data.forEach((item)=>{
          row_counter++;
          table_rows= '<tr id="row'+item.id+'" class="w3-animate-zoom"><td>';
          table_rows+=item.id_number_type.abbreviation+ ' - ' + item.id_number+ '</td>';
          table_rows+='<td>'+item.name+ ' ' + item.lastname + '</td>';
          table_rows+='<td>'+item.relation_type.type+'</td>';
          // table_rows+='<td><select class="custom-select relationships" name='+item.id+' route="/'+properties.route_entity+'/'+item.id+'">';
          //    console.log('item type', item.name, item.relation_type.type);
          //   properties.relationships.forEach(relationship => {
          //   console.log('type', relationship.type);
          //   if(relationship.type==item.relation_type.type){ table_rows+='<option selected>'+relationship.type; }
          //   else {table_rows+='<option>'+relationship.type; }
          //   table_rows+='</option>';
          // });
          // table_rows+='</select></td>';
          table_rows+='<td>'+item.created_at+ '</td>';
          // if(item.verified_at==null){ table_rows+='<td>En espera.</td>';}
          // else{table_rows+='<td>'+item.verified_at+ '</td>';}   
          // if(item.verified_at==null){ 
          //   if(item.is_token_expired==1){
          //     table_rows+='<td><i id="resend_mail'+item.id+'" data-toggle="tooltip" data-placement="left" title="Puede re-enviar otro correo de solicitud a '+(item.person.name + ' ' + item.person.lastname)+' para ser agregado/a a su perfil haciendo click en este boton." disabled class="fas fa-mail-bulk icon_button resend_mail" ></i></td>';
          
          //   }else {
          //     table_rows+='<td><i data-toggle="tooltip" data-placement="left" title="No puede enviar otro correo porque el correo anterior sigue vigente, espere a que '+(item.person.name + ' ' + item.person.lastname)+' procese la solicitud, si esta expira podra enviar otro correo a esta persona." class="fas fa-mail-bulk" style="color:gray;"></i></td>';
          //   }
          // }else { table_rows+='<td></td>'; }
          table_rows+='<td><i id="edit'+item.id+'"" data-toggle="modal" data-target="#person_modal" class="fas fa-edit update text-bold table-icon "></i></td>';
          table_rows+='<td><i id="remove_person'+item.id+'" class="fas fa-trash-alt text-bold  table-icon delete_person"></i></td>';
          table_rows+= '</tr>';
      
          $(properties.tbody_id).append(table_rows).hide().fadeIn();
        });

        for (let i = 0; i < (properties.per_page-row_counter); i++) {
            $(properties.tbody_id).
            append('<tr><td style="color:rgb(0,0,0,0);">none</td><td></td><td></td><td></td><td></td><td></td></tr>')
            .hide().fadeIn();
        }
        event_properties.forEach((event)=>{ attachEvent(event); });

        if(properties.modal_id){ 
          $(properties.modal_id).modal('hide');
        }
    }//populate function

    //events
    $('#insert_person_btn').on('click', function () {
      route = "{{route('user_companions.store')}}"; 
      setUserPersonForm({insert:true});
      $('#modal_title').text('Agregar Persona');
      route={ path:"{{route('user_companions.store')}}", verb:'POST' }
    });
    function getUserPerson($id) {
      $.ajax( {
      method: "GET",
      url: '/user_companions.show/'+16,
      success: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
          refreshPeopleTable('#add_new_person');
          if(serverResponse.success){
            displaySwal(serverResponse.message, {
              title:'Persona agregada',
              icon:'success'
            });
          } else { displaySwal(serverResponse.message); }
      },
      error: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        displaySwal('Hubo un error con su petición, intente nuevamente.'); 
      }//error
      });
    }
    $('.add_people').on('click', function () {
      $('.waiting').fadeIn();
      console.log(route);
      $.ajax( {
      method: route.verb,
      url: route.path,
      data: $('#userPeopleForm').serialize(),
      success: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
          refreshPeopleTable('#add_new_person');
          if(serverResponse.success){
            setUserPersonForm({insert:true});
            $('#person_modal').modal('hide');
            displaySwal(serverResponse.message, {
              title:'Operación exitosa',
              icon:'success'
            });

            //close modal, reset fields, and actually update
          } else { displaySwal(serverResponse.message); }
      },
      error: (serverResponse) => { console.log(serverResponse);
        $('.waiting').fadeOut();
        if(serverResponse.status == 422){
          var errors='';
          response_errors = serverResponse.responseJSON.errors;
          errors = processAll422Errors([
            {errors: response_errors.id_number_type, field_name: 'Tipo de identificación'},
            {errors: response_errors.id_number, field_name: 'Número de identificación'},
            {errors: response_errors.relation_type, field_name: 'Tipo de relación'},
            {errors: response_errors.name, field_name: 'Nombre'},
            {errors: response_errors.lastname, field_name: 'Apellido'},
            {errors: response_errors.phone_number, field_name: 'Télefono'},
            {errors: response_errors.email, field_name: 'Correo'},
            {errors: response_errors.address, field_name: 'Dirección'},
            {errors: response_errors.birth_date, field_name: 'Fecha de nacimiento'},
          ]);
          displaySwal(errors);
        }else { displaySwal('Hubo un error con su petición, intente nuevamente.'); } 
      }//error
      });

    });

    //show people depending on select option

    $('#people_type_select').on('change', function () {
      let route="{{route('adults.index')}}";
      if($(this).val()=='Menores de edad'){ route="{{route('underages.index')}}"; }
      refreshTable({
        route: route, 
        entity:'related_people',
        populateTable: populateUserPeopleTable, 
        tbody_id:'#user_people_rows',
        next_page_id: '#next_page'
      });
    });

    // $('.open_people_modal').on('click' , setPeopleModal);
    //pagination

    refreshPeopleTable();
    setNavBtnEvents({
      route: "{{route('adults.index')}}", 
      entity:'related_people',
      populateTable: populateUserPeopleTable, 
      tbody_id:'#user_people_rows',
      next_page_id: '#next_page'
    });
</script>
@endsection
