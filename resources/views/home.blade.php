@extends('layouts.app')

@section('content')
    <!--carousel-->
    <div id="hotel_images" class="carousel slide shadow" data-ride="carousel" data-interval="5000">
       
       
        <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/carousel/pool.jpg" alt="Los Angeles" class="main-carousel-img">
                <div class="carousel-color"></div>
            </div>
            <div class="carousel-item">
                <img src="images/carousel/hotel_room.jpg" alt="Chicago" class="main-carousel-img">
                <div class="carousel-color"></div>
            </div>
            <div class="carousel-item">
                <img src="images/carousel/hotel_lobby.jpg" alt="New York" class="main-carousel-img">
                <div class="carousel-color"></div>
            </div>
            <form action="#" class="text-white carousel-form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="check_in">Check In:</label>
                        <input type="text" class="form-control hotel_input shadow"
                        id="check_in" placeholder="Ingrese fecha de llegada...">
                        <small id="check_in_help" class="form-text text-white">Por favor,
                        ingrese la fecha de su llegada en formato día/mes/año.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="check_out">Check-Out:</label>
                        <input type="text"  class="form-control hotel_input shadow " 
                        id="check_out" placeholder="Ingrese fecha de salida...">
                        <small id="check_out_help" class="form-text text-white">Por favor,
                        ingrese la fecha de su salida en formato día/mes/año.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="kids">Acompañantes:</label>
                        <input type="number" class="form-control hotel_input shadow" 
                        id="kids" placeholder="Cantidad de acompañantes...">
                        <small id="people_number_help" class="form-text text-white">Por favor,
                        ingrese la cantidad de acompañantes.</small>
                    </div>
                     <!--<div class="form-group col-md-6">
                        <label for="rooms">Habitaciones:</label>
                        <input type="number" class="form-control hotel_input shadow" id="rooms">
                    </div> -->
                </div>
                <button type="button" class="reservation_search_btn text-dark mt-3">Consultar</button>
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
    <div id="rooms" class="carousel slide mt-3" data-ride="carousel">
        
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
@endsection
