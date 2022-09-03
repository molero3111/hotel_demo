@extends('layouts.admin_panel')

@section('content')
    <h1 class="text-center">Suministros</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <a href="#" class="btn btn-secondary btn-icon-split mx-auto" id="add_currency">
              <span class="text">Agregar suministro</span>
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>En almacén</th>
                  <th>Costo</th>
                  <th>Precio de venta</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="supply_rows">
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
  <!-- add bank Modal-->
  <div class="modal fade" id="add_supply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

      function getSupplies(data){
        $('#supply_rows tr').remove();
            for(let i=0; i < data.length; i++){
                
                let rows =  '<tr>'+
                '<td>'+ data[i]['id'] +'</td>'+
                '<td ><div class="row"><img  style="width:50px; height:50px;" class="mx-auto" src="'+route_root+ 'images/products/'+ data[i]['picture'] + '"   /></td></div>'+
                '<td>'+ data[i]['name'] +'</td>'+
                '<td>'+ data[i]['in_stock'] +'</td>'+
                '<td>$'+ data[i]['cost'] +' (USD)</td>'+
                '<td>No es producto</td>'+
                '<td><i id="add'+data[i]['id']+'" data-toggle="modal" data-target="#updateIdNumberModal" class="edit fas fa-edit "></i></td>'+
                '<td><i id="remove'+data[i]['id']+'" class="fas fa-trash-alt text-bold  table-icon delete_person"></i></td>'+
                '</tr>';

                let asset = 'images/products/'+ data[i]['picture'];
                if(data[i]['product']){       
                    rows =  '<tr>'+
                    '<td>'+ data[i]['id'] +'</td>'+
                    '<td ><div class="row"><img style="width:50px; height:50px;" class="mx-auto"  src="'+route_root+ 'images/products/'+ data[i]['picture'] + '" /></td></div>'+
                    '<td>'+ data[i]['name'] +'</td>'+
                    '<td>'+ data[i]['in_stock'] +'</td>'+
                    '<td>$'+ data[i]['cost'] +' (USD)</td>'+
                    '<td>$'+ data[i]['product']['price']+' (USD)</td>'+
                    '<td><i id="add'+data[i]['id']+'" data-toggle="modal" data-target="#updateIdNumberModal" class="edit fas fa-edit "></i></td>'+
                    '<td><i id="remove'+data[i]['id']+'" class="fas fa-trash-alt text-bold  table-icon delete_person"></i></td>'+
                    '</tr>';
                }
                $('#supply_rows').prepend(rows);
            }
      }
      refreshTable({
        route:'{{route("supplies.index")}}',
        page:1,
        entity:'supplies',
        no_row_message: 'No hay suministros agregados.',
        populateTable: getSupplies,
        tbody_id:'#supply_rows',
        is_admin_panel: true,
      });
    </script>
@endsection
