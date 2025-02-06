@extends('frontend.layouts.app')
@section('title', 'Profile' . ' | Buntu Delice ')
@section('style')
<link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container" style="text-align: center;">
			    <h2>Profile <br></h2>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Profile</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu">
	    <div class="container">
	        <div class="w3spl-menu">
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
        <img src="{{ auth()->user()->image ? url('images/profile_images/' . auth()->user()->image) : url('assets/images/user-avatar.png') }}" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6><br>
        <input type="file" class="text-center center-block file-upload">
      </div></hr><br>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                <li><a data-toggle="tab" href="#messages">Active Orders</a></li>
                <li><a data-toggle="tab" href="#settings">Completed Orders</a></li>
              </ul>

              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="##" method="post">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>Full Name:</strong>
                                    <input type="text" name="first_name" class="form-control" value="@if(Auth::check()) {{auth()->user()->name}} @else  @endif"/>
                                </div>
                                <div class="span1"></div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Email Address:</strong>
                                    <input type="text" class="form-control" value="@if(Auth::check()) {{auth()->user()->email}} @else  @endif"/>
                                </div>
                            </div>
                            <div class="span1"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>Phone:</strong>
                                    <input type="text" name="first_name" class="form-control" value="@if(Auth::check()) {{auth()->user()->phone}} @else  @endif"/>
                                </div>
                                <div class="span1"></div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Password:</strong>
                                    <input type="text" class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            </div>
                      </div>
              	</form>
              
              <hr>
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="messages">
               <table class="table table-head-fixed text-nowrap id="example1">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Product</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Placed at</th>
							</tr>
						</thead>
						<tbody>
						    @php
						    $orders=DB::table('orders')
						    ->join('restaurants', 'restaurants.id', '=', 'orders.restaurant_id')
						    ->join('products', 'products.id', '=', 'orders.product_id')
						    ->select('orders.order_no', 'orders.status', 'orders.user_id', 'orders.qty', 'orders.total', 'orders.created_at', 'restaurants.name as restaurant_name', 'products.name as pro_name', 'products.price')
						    ->where('orders.user_id',auth()->user()->id)->get();
						    @endphp
						    @if($orders->count()!=0)
						    @foreach($orders as $order)
							<tr>
								<td>{{$order->order_no}}</td>
								<td>{{auth()->user()->name}}</td>
								<td>{{$order->pro_name}}</td>
								<td>{{$order->price}}</td>
								<td>{{$order->qty}}</td>
								<td>{{$order->status}}</td>
								<td>2{{$order->created_at}}</td>
							</tr>
						    @endforeach
						    @else
						    <tr>
								<td colspan="6"><center><b>No Order Found!</b></center></td>
							</tr>
						    @endif
							
						</tbody>
					</table>
               
               <hr>
               
             </div><!--/tab-pane-->
             <div class="tab-pane" id="settings">
                  <hr>
                  <table class="table table-head-fixed text-nowrap id="example1">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Driver</th>
								<th>Product</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Placed at</th>
							</tr>
						</thead>
						<tbody>
						     @php
						    $orders=DB::table('completed_orders')
						    ->join('drivers', 'drivers.id', '=', 'completed_orders.driver_id')
						    ->join('restaurants', 'restaurants.id', '=', 'completed_orders.restaurant_id')
						    ->join('products', 'products.id', '=', 'completed_orders.product_id')
						    ->select('completed_orders.order_no', 'completed_orders.status', 'completed_orders.user_id', 'completed_orders.qty', 'completed_orders.total', 'completed_orders.created_at', 'drivers.name as driver_name', 'restaurants.name as restaurant_name', 'products.name as pro_name', 'products.price')
						    ->where('completed_orders.user_id',auth()->user()->id)->get();
						    @endphp
						    @if($orders->count()!=0)
						    @foreach($orders as $order)
							<tr>
								<td>{{$order->order_no}}</td>
								<td>{{auth()->user()->name}}</td>
								<td>{{$order->driver_name}}</td>
								<td>{{$order->pro_name}}</td>
								<td>{{$order->price}}</td>
								<td>{{$order->qty}}</td>
								<td>{{$order->status}}</td>
								<td>2{{$order->created_at}}</td>
							</tr>
						    @endforeach
						    @else
						    <tr>
								<td colspan="6"><center><b>No Order Found!</b></center></td>
							</tr>
						    @endif
							
						</tbody>
					</table>
              </div>
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
        </div>
    </div> 
	</div>
	<!-- //menu list -->    
	@endsection 
	@section('script')

<script src="{{ asset(env('ASSET_URL') .'plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable();
  
    });
  </script>
@endsection
	