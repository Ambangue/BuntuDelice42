@extends('layouts.app')
@section('title','Order Details')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('order_nav', 'active')
@section('order_nav_open', 'menu-open')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="">Orders</a></li>
                        <li class="breadcrumb-item active">{{$order->order_no}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center" >
                <div class="col-11">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="rounded-circle" style="border: 2px solid #007bff;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/restaurant_images/'.$order->restaurant->logo)}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{$order->restaurant->name}}</h3>

                                <p class="text-muted text-center"><b>Services: </b> {{$order->restaurant->services}}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$order->restaurant->email}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{$order->restaurant->phone}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">{{$order->restaurant->address}}</a>
                                  </li>
                                </ul>

                                <a href="" class="btn bg-gradient-primary btn-block"><b>Restaurant</b></a>
                              </div>
                              <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-md-4">
                        	@if($order->driver)
                            <div class="card card-warning card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                    @if($order->driver->image)
                                    <img class="rounded-circle" style="border: 2px solid #ffc107;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/driver_images/'.$order->driver->image)}}" alt="User profile picture">
                                    @else
                                    <img class="rounded-circle" style="border: 2px solid #ffc107;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/5-512.png')}}" alt="User profile picture">
                                    @endif
                                </div>

                                <h3 class="profile-username text-center">{{$order->driver->name}}</h3>

                                <p class="text-muted text-center">{{$order->driver->user_name}}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$order->driver->email}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{$order->driver->phone}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">{{$order->driver->address}}</a>
                                  </li>
                                </ul>

                                <a href="#" class="btn bg-gradient-warning btn-block"><b>Driver</b></a>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            @else
                            <div class="card card-warning card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="rounded-circle" style="border: 2px solid #ffc107;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/5-512.png')}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">Driver Name</h3>

                                <p class="text-muted text-center">Driver</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">xxxxxx</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">xxxxxx</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">xxxxxx</a>
                                  </li>
                                </ul>

                                <a href="#" class="btn bg-gradient-warning btn-block"><b>Driver Not Assigned</b></a>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card card-success card-outline">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                    @if($order->user->image)
                                    <img class="rounded-circle" style="border: 2px solid #28a745;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/profile_images/'.$order->user->image)}}" alt="User profile picture">
                                    @else
                                    <img class="rounded-circle" style="border: 2px solid #28a745;" width="75" height="75" src="{{asset(env('ASSET_URL') .'images/5-512.png')}}" alt="User profile picture">
                                    @endif
                                </div>

                                <h3 class="profile-username text-center">{{$order->user->name}}</h3>

                                <p class="text-muted text-center">User</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$order->user->email}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{$order->user->phone}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">{{$order->user->address}}</a>
                                  </li>
                                </ul>

                                <a href="" class="btn bg-gradient-success btn-block"><b>User</b></a>
                              </div>
                              <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-cart-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Order Number</span>
                <span class="info-box-number">
                  {{$order->order_no}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tax</span>
                <span class="info-box-number">{{$order->tax}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Delivery Fee</span>
                <span class="info-box-number">{{$order->delivery_charges}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tip</span>
                <span class="info-box-number">{{$order->driver_tip}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Subtotal</span>
                <span class="info-box-number">{{$order->sub_total}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number">{{$order->total}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="card ">
                              <div class="card-body">
                                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Image</th>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($products as $index => $pro)
                    <tr>
                      <td>{{++$index}}</td>
                      <td><img src="{{url('images/product_images',$pro->product->image)}}" class="img-circle elevation-2" alt="User Image" width="65"></td>
                      <td>{{$order->product->name}}</td>
                      <td>{{$order->qty}}</td>
                      <td>{{$order->product->price}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                </div></div>
                                </div>
                           <div id="map" class="w-100" style="border:0; height: 350px;"></div>  
                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="small-box ">
                                        <div class="inner">

                                            <h3>Status</h3>
                                        </div>
                                        <a class=" text-white bg-gradient-danger small-box-footer">{{$order->status}}</a>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="small-box ">
                                        <div class="inner">

                                            <h3>Ordered Date</h3>
                                        </div>
                                        <a class=" text-white bg-gradient-success small-box-footer">{{$order->created_at}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script src="{{asset(env('ASSET_URL') .'plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset(env('ASSET_URL') .'plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
 <script>
        var pickup = {lat: @if($order->driver==null) 32.6576343 @else {{$order->driver->latitude}}  @endif, lng: @if($order->driver==null) 74.6487362  @else {{$order->driver->longitude}}  @endif};
        var dropoff = {lat: {{$order->d_lat}}, lng: {{$order->d_lng}}};
      function initMap() {
        
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: pickup
        });
        directionsRenderer.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsRenderer);

      }

       function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        // var selectedMode = document.getElementById('mode').value;
        directionsService.route({
          origin: pickup,  
          destination: dropoff,  
          travelMode: google.maps.TravelMode['DRIVING']
        }, function(response, status) {
          if (status == 'OK') {
              console.log(response);
            directionsRenderer.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
</script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkXFIvxvN0M1Chg644bLwAnXEQUG_RKUI&callback=initMap"></script>
@endsection