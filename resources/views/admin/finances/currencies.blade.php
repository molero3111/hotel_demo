@extends('layouts.admin_panel')

@section('content')
    <h1 class="text-center">Monedas</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <a href="#" class="btn btn-secondary btn-icon-split mx-auto" id="add_currency">
              <span class="text">Agregar Moneda</span>
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Moneda</th>
                  <th>Código ISO</th>
                  <th>Símbolo</th>
                  <th>Equivalente en dolares (USD)</th>
                  <th colspan="2"></th>
                  {{-- <th></th> --}}
                </tr>
              </thead>
              <tbody id="currency_rows">
              </tbody>
            </table>
          </div>
        </div>
        <div id="dataTable_paginate " class="dataTables_paginate paging_simple_numbers row">
          <ul class="pagination mx-auto">
            <li id="previous_page" class="paginate_button page-item previous page_navigation">
              <a class="page-link" href="#" aria-controls="dataTable" route='1'  data-dt-idx="0" tabindex="0">&laquo;</a>
            </li>
            {{-- data --}}
            <li id="next_page" class="paginate_button page-item next page_navigation ">
              <a class="page-link " href="#" aria-controls="dataTable" route='1' data-dt-idx="0" tabindex="0">&raquo;</a>
            </li>
          </ul>
        </div>
      </div>
  <!-- add currency Modal-->
  <div class="modal fade" id="add_currency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>
    <script>

      function getCurrencies(data){
        $('#currency_rows tr').remove();
            for(let i=0; i < data.length; i++){
              $('#currency_rows').prepend(
                '<tr>'+
                '<td>'+ data[i]['name'] +'</td>'+
                '<td>'+ data[i]['iso_code_abbreviation'] +'</td>'+
                '<td>'+ data[i]['symbol'] +'</td>'+
                '<td>'+ data[i]['dollar_equivallent'] +'</td>'+
                '<td><i id="" id_number_type="P" id_number="4343434252" data-toggle="modal" data-target="#updateIdNumberModal" class="edit fas fa-edit "></i></td>'+
                '<td><i id="remove_person15" class="fas fa-trash-alt text-bold  table-icon delete_person"></i></td>'+
                '</tr>'
            );
            }
      }
      refreshTable({
        route:'{{route("currencies.index")}}',
        page:1,
        entity:'currencies',
        no_row_message: 'No hay monedas agregadas.',
        populateTable: getCurrencies,
        tbody_id:'#currency_rows',
        is_admin_panel: true,
      });

      // function refreshTable({
      //   route: '{{route("currencies.index")}}',
      //   data: {page:}
      // }) ;
        //  $.ajax( {
        // method: "GET",
        // url: properties.route,
        // data: {page:properties.page},
        // success: (serverResponse) => { console.log(serverResponse);
        //    my_pagination=serverResponse[properties.entity];
        //    setNavBtns();
        //     if(serverResponse[properties.entity]['total'] < 1){
        //         displaySwal(properties.no_row_message);  
                
        //     }

        //     properties.populateTable(
        //         serverResponse[properties.entity]['data'],
        //         {
        //             tbody_id: properties.tbody_id,
        //             per_page: serverResponse[properties.entity]['per_page'],
        //             modal_id:serverResponse[properties.entity]['modal_id'],
        //             relationships: serverResponse.relationship_types,
        //             route_entity: serverResponse.route_entity
        //         }
        //     );
            
        //     setPagination({
        //         route: properties.route,
        //         tbody_id: properties.tbody_id,
        //         page: properties.page,
        //         entity: properties.entity
        //     });

        //     if(properties.modal_id){  $(properties.modal_id).modal('hide');  }
        // },
        // error: (serverResponse) => { console.log(serverResponse);
        //   displaySwal('Hubo un error con su petición, intente nuevamente.')
        //   .then((value)=>{location.href='/'});   }//error
        // });
    </script>
@endsection
