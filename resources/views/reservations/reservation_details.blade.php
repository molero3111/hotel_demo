@extends('layouts.app')

@section('content')
    
    <h2 class="text-center mt-4 titles">Detalles de la Reservación</h2>
    <div class="container" id="details">
        <div class="row">
            <div class="col-sm-6 "><span class="bold">Solicitada</span>: {{$reservation->created_at}}</div>
            <div class="col-sm-6 "><span class="bold">Días de estadía</span>: {{$reservation->days}}</div>
        </div>
        <div class="row mt-3">   
            <div class="col-sm-6 "><span class="bold">Ingreso</span>: {{$reservation->check_in}}</div>
            <div class="col-sm-6 "><span class="bold">Salida</span>: {{$reservation->check_out}}</div>
        </div>
        <h4 class="mt-4 text-center">Habitaciones:</h4>
        <div class="table-responsive-sm">
            <table class="table table-striped mt-3 text-center">
                <thead class="thad-dark">
                  <tr>
                    <th scope="col">Número</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total por habitación</th>
                  </tr>
                </thead>
                <tbody id="room_table_rows">
                    @foreach ($reservation->rooms as $room)
                        <tr>
                            <td>{{$room->room_number}}</td>
                            <td>{{$room->type->type}}</td>
                            <td>${{$room->type->price_per_day}}</td>
                            <td>${{$room->type->price_per_day*$reservation->days}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> {{--rooms --}}
        <div class='row '><span class="dark-background w-25 mt-3 mx-auto"><button type="button" id="add_extra_room" class=" hotel_button text-dark w-100">Habitaciones Extra</button></span></div>
        <h4 class="mt-4 text-center">Acompañantes:</h4>
        <div class="table-responsive-sm">
            <table class="table table-striped mt-3 text-center">
                <thead class="thad-dark">
                  <tr>
                    <th scope="col">Indentificación</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Parentesco</th>
                  </tr>
                </thead>
                <tbody id="room_table_rows">
                    @foreach ($reservation->companions as $companion)
                        <tr>
                        <td>{{$companion->id_number_type->abbreviation}} - {{$companion->id_number}}</td>
                        <td>{{$companion->name}}</td>
                        <td>{{$companion->lastname}}</td>
                        <td>{{$companion->relation_type->type}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> {{--companions --}}
        <div class='row '><span class="dark-background w-25 mt-3 mx-auto"><button type="button" id="add_extra_companion" class=" hotel_button text-dark w-100">Agregar Acompañantes</button></span></div>
    </div>  {{--details --}}

    {{-- <hr/> --}}
    <div class="container" id="payment_details">
        <h3 class="titles mt-4 text-center">Pagos</h3>
        {{-- <h4 class="mt-3 ">Pagos de reserva:</h4> --}}
        @foreach ($reservation->payments as $payment)
        <div class="row">
            <div class="col-sm-6 "><span class="bold">Asunto</span>: {{$payment->payment_service->service}}</div>
            <div class="col-sm-6 "><span class="bold">Total</span>: <span id='total'>${{$payment->total}}</span></div>
        </div>
        <div class="row">
            <div class="col-sm-6 "><span class="bold">Total Pagado</span>:<span id='paid'>${{($reservation->total_paid)}}</span></div>
            <div class="col-sm-6 "><span class="bold">Pago Restante</span>: <span id='to_pay'>${{$payment->total-$reservation->total_paid}}</span></div>
        </div>
        <script>
            if($('#paid').text()==$('#total').text()){$('#paid').css('color', 'green').css('text-shadow', '0px 0px 5px black');;}
            else{$('#paid').css('color', 'red').css('text-shadow', '0px 0px 5px black');}

            if($('#to_pay').text()==0){$('#to_pay').css('color', 'green').css('text-shadow', '0px 0px 5px black');;}
            else{$('#to_pay').css('color', 'red').css('text-shadow', '0px 0px 5px black');}
        </script>
        <h4 class="mt-3 ">Pagos Realizados:</h4>
        <div class="table-responsive-sm">
            <table class="table table-striped mt-3 text-center">
                <thead class="thad-dark">
                  <tr>
                    <th scope="col">Tipo</th>
                    <th scope="col">Fecha de registro</th>
                    <th scope="col">Verificado</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody id="payment_table_rows">
                    @foreach ($payment->bank_movements as $movement)
                        <tr>
                            <td>{{$movement->payment_type->name}}</td>
                            <td>{{$movement->created_at}}</td>
                            <td>{{$movement->verified_at}}</td>
                            <td>{{$movement->bank_account->bank->currency->symbol}} {{$movement->total}} - ${{$movement->total/$movement->equivallent_in_dollars}}</td>
                            <td><a href="#"><i id='{{$movement->id}}' class="fas fa-eye text-bold table-icon show_movement_details"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
        @if($payment->total-$reservation->total_paid > 0)
            <div class='row '><span class="dark-background w-25 mt-3 mx-auto"><button type="button" id="add_payment_btn" class=" hotel_button text-dark w-100">Pagar</button></span></div>
        @endif
    </div>  {{-- payment_details --}}
   
    {{-- modals --}}
    {{--payment details modals--}}
    <div id="movement_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content bg-transparent-black">
                <div class="modal-header">
                    <h4 id="modal_title" class="modal-title form-text text-white"></h4>
                </div>
                <div class="modal-body">
                    <p class="text-white" id='created_at'></p>
                    <p class="text-white" id='paid_at'></p>
                    <p class="text-white" id='verified_at'></p>
                    <p class="text-white" id='movement_total'>g</p>
                    <p class="text-white" id='dollar_equivallent'></p>
                    <p class="text-white" id='total_in_dollars'></p>
                    <p class="text-white" id='reference_number'></p>
                    <p class="text-white" id='bank'></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div id="add_payment_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
  
      <!-- Modal content-->
      <div class="modal-content bg-transparent-black">
        <div class="modal-header">
          <h4 id="modal_title" class="modal-title form-text text-white">Agregar Pago</h4>
        </div>
        <div class="modal-body">
            <form action="#" method="POST" class="text-white w3-animate-zoom" id="userPeopleForm">
                <small class="form-text text-white">Seleccione Banco:</small>
                <div class="form-group ">
                    <select name="select_bank" id="select_bank" class="custom-select hotel_input shadow">                                                      
                    </select>
                </div>
                <div class="form-group ">
                    <small class="form-text text-white">Número de referencia:</small>
                    <input type="text" class="form-control hotel_input shadow"
                    id="reference" maxlength="80" name="reference" required 
                    placeholder="Número de referencia..."
                    autocomplete="" autofocus />
                </div>
                <div class="form-group ">
                    <small class="form-text text-white">Total:</small>
                    <input type="text" class="form-control hotel_input shadow"
                    id="total_paid" maxlength="1000" name="total_paid" required 
                    placeholder="Total"
                    autocomplete="" />
                </div>
                <div class="form-group ">
                    <small class="form-text text-white">Fecha de pago:</small>
                    <input type="text" class="form-control hotel_input shadow datepicker"
                    id="payment_date" name="payment_date" required 
                    placeholder="fecha de pago"
                    autocomplete="" />
                </div>
                @csrf 
                <p  class="w3-animate-zoom waiting mt-3">
                    <i class="fa fa-spinner w3-spin "></i>
                </p>
        </div>
          <div class="modal-footer">
            <button type="button" class="hotel_button text-dark" data-dismiss="modal">Cerrar</button>
            <button type="button" id="payment_btn"class="add_people hotel_button text-dark ">Continuar</button>
           </div>
          </form>
      </div>
    <script>
        $('.show_movement_details').on('click', function (e) {
        $('.waiting').fadeIn();
        $.ajax( {
        method: 'GET',
        url: route_root + 'payments/movements/'+e.target.id,
        success: (serverResponse) => { console.log(serverResponse);           
            if(serverResponse.success){
                $('#modal_title').text('Pago #' + serverResponse.bank_movement.reference_number);
                $('#created_at').text('Fecha de registro: ' + serverResponse.bank_movement.created_at);
                $('#paid_at').text('Fecha de pago: ' + serverResponse.bank_movement.paid_at);
                $('#verified_at').text('Fecha de verificación: ' + serverResponse.bank_movement.verified_at);
                $('#movement_total').text('Total: ' + serverResponse.bank_movement.bank_account.bank.currency.symbol + 
                ' ' + serverResponse.bank_movement.total );
                $('#dollar_equivallent').text('Equivalente en dolares (USD): ' + '$1 = '+ serverResponse.bank_movement.bank_account.bank.currency.symbol +
                ' ' + serverResponse.bank_movement.equivallent_in_dollars);
                $('#total_in_dollars').text('Total en dolares (USD): $' + 
                (serverResponse.bank_movement.total/serverResponse.bank_movement.equivallent_in_dollars));
                $('#reference_number').text('Número de referencia: ' + serverResponse.bank_movement.reference_number);
                $('#bank').text('Banco: ' + serverResponse.bank_movement.bank_account.bank.name);

                $('.waiting').fadeOut();
                $('#movement_modal').modal('show');

            } else { $('.waiting').fadeOut();displaySwal(serverResponse.message);}
        },
        error: (serverResponse) => { console.log(serverResponse);
            $('.waiting').fadeOut();
            displaySwal('Hubo un error con su petición, intente nuevamente.'); 
        }//error
        });

        });

        $('#add_payment_btn').on('click', function () {
        $('.waiting').fadeIn();
            $.ajax( {
                method: 'GET',
                url: '{{route("movements.create")}}',
                success: (serverResponse) => { console.log(serverResponse);    
                    for (let i = 0; i < serverResponse.banks.length; i++) {
                        // $('#select_bank').append('<option>'+ serverResponse.banks[i].name + ' ('+ serverResponse.banks[i].currency.iso_code_abbreviation + ')</option>');
                        $('#select_bank').append('<option>'+ serverResponse.banks[i].name + '</option>');

                    }
                    $('.waiting').fadeOut();
                    $('#add_payment_modal').modal('show');
                    
                },
                error: (serverResponse) => { console.log(serverResponse);
                    $('.waiting').fadeOut();  displaySwal('Hubo un error con su petición, intente nuevamente.'); 
                }//error
            });

        });

        $('#payment_btn').on('click', function () {
        $('.waiting').fadeIn(); console.log('total' , $('#reference').val());
            $.ajax( {
                method: 'POST',
                url: '{{route("movements.store")}}',
                data: {
                    payment_id: "{{$payment->id}}",
                    bank: $('#select_bank').val(),
                    reference: $('#reference').val(),
                    payment_date: $('#payment_date').val(),
                    total: $('#total_paid').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: (serverResponse) => { console.log(serverResponse); 
                    $('.waiting').fadeOut();
                    $('#add_payment_modal').modal('hide');
                    // displaySwal(serverResponse.message,
                    //     success:{title: "Pago agregado",
                    //     icon: "success"}
                        swal({
                        title: 'Pago agregado',
                        content: {
                            element: "p",
                            attributes: {
                            innerHTML: '<p class="swal-color" >'+serverResponse.message+'</p>'
                            }
                        },
                        icon: 'success',
                        buttons:{ confirm:'Aceptar'},
                        className: "alert",
                        }).then((value) => {location.href= route_root + 'show_user_reservations';});
                    

                },
                error: (serverResponse) => { console.log(serverResponse);
                    $('.waiting').fadeOut();  displaySwal('Hubo un error con su petición, intente nuevamente.'); 
                }//error
            });

        });

        $.datetimepicker.setLocale('es');

        $('#payment_date').datetimepicker({
        timepicker:false,
        datepicker:true,
        format: 'd-m-Y',
        value: getCurrentDate(),
        weeks:true,
        theme:'dark',
        mask: true,
        lang: 'es'
        });
        
  </script>
@endsection