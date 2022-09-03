@extends('layouts.app')

@section('content')

    <h2 class="text-center mt-2 mb-2">Productos</h2>
    <div class="container">
      <div class="row">
        <div class="input-group w-50 mt-3 mb-3 mx-auto">
          <input type="text" class="form-control" placeholder="Buscar producto" />
          <div class="input-group-append">
            <span class="input-group-text reserve_hoel_button">Buscar</span>
          </div>
        </div>
      </div>
      <div id="product_display" class="row">

      </div>
    </div>
 
    <nav class="mt-3 mb-5 ">
        <ul class="pagination justify-content-center" id='adult_pagination'>
          <li class="page-item page_navigation" id="previous_page" page='false'>
            <a class="page-link hotel-item" href="#" route='0' name='1' aria-label="Previous">&laquo;</a>
          </li>
          <li class="page-item page_navigation"  page='false'>
            <a class="page-link hotel-item" href="#" route='0' name='1' aria-label="Previous">1</a>
          </li>
          {{-- user's people --}}
          <li class="page-item page_navigation" id="next_page"  page='false'>
            <a class="page-link hotel-item " href="#" aria-label="Next" route='0' name='2'>&raquo;</a>
          </li>
        </ul>
    </nav>
{{-- add new product modal --}}
<!-- Modal -->
<script>

    function displayProducts(data) {
        for (let i = 0; i < data.length; i++) {

            $('#product_display').prepend(
              '<div class="col-md-4 mt-4 ">'+
                '<div class="card-deck ">'+
                    '<div class="card bg-transparent-black shadow" >'+
                        '<img class="card-img-top" src="images/products/'+data[i]['supply']['picture']+'" alt="Card image">'+
                        '<div class="card-body">'+
                            '<h4 class="card-title text-center text-hotel-orange">'+data[i]['supply']['name']+'</h4>'+
                            '<p class="text-center text-hotel-orange">$'+data[i]['price']+'</p>'+
                            '<button class="room_btn text-dark">agregar</button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
              '</div'
            );
            
        }
    }

    $.ajax( {
    method: "GET",
    url: "{{route('products.index')}}",
    success: (serverResponse) => { console.log(serverResponse);
        
        displayProducts(serverResponse.products.data);
    },
    error: (serverResponse) => { console.log(serverResponse);
    displaySwal('Hubo un error con su petición, intente nuevamente.'); 
    }//error
    });

</script>
@endsection
