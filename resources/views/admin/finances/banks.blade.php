@extends('layouts.admin_panel')

@section('content')
    <h1 class="text-center">Bancos</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row mb-2">
            <a href="#" class="btn btn-secondary btn-icon-split mx-auto" id="add_currency">
              <span class="text">Agregar Banco</span>
              <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
              </span>
            </a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Banco</th>
                  <th>Acronimo</th>
                  <th>Moneda</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody id="bank_rows">
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

      function getBanks(data){
        $('#bank_rows tr').remove();
            for(let i=0; i < data.length; i++){
              $('#bank_rows').prepend(
                '<tr>'+
                '<td>'+ data[i]['name'] +'</td>'+
                '<td>'+ data[i]['abbreviation'] +'</td>'+
                '<td>'+ data[i]['currency']['name'] +'</td>'+
                '<td><i id="" id_number_type="P" id_number="4343434252" data-toggle="modal" data-target="#updateIdNumberModal" class="edit fas fa-edit "></i></td>'+
                '<td><i id="remove_person15" class="fas fa-trash-alt text-bold  table-icon delete_person"></i></td>'+
                '</tr>'
            );
            }
      }
      refreshTable({
        route:'{{route("banks.index")}}',
        page:1,
        entity:'banks',
        no_row_message: 'No hay bancos agregados.',
        populateTable: getBanks,
        tbody_id:'#bank_rows',
        is_admin_panel: true,
      });
    </script>
@endsection
