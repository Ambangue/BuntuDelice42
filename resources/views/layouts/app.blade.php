<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}">
    <!-- Font Awesome -->
    <link 
  href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset(env('ASSET_URL') .'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'dist/css/adminlte.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="{{ asset(env('ASSET_URL') .'plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    @yield('style')
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<style>
    .brand1-image {
    float: left;
    line-height: .8;
    max-height: 34px;
    width: auto;
    margin-left: .8rem;
    margin-right: .5rem;
    margin-top: -3px;
    border-radius: 50%;
}
.elevation-2 {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

	.modal.right .modal-dialog {
		position: fixed;
		margin-top: 56px;
		width: 320px;
		height: 100%;
		-webkit-transform: translate3d(0%, 0, 0);
		    -ms-transform: translate3d(0%, 0, 0);
		     -o-transform: translate3d(0%, 0, 0);
		        transform: translate3d(0%, 0, 0);
	}


	.modal.right .modal-content {
		height: 100%;
		overflow-y: auto;
	}


	.modal.right .modal-body {
		padding: 0px;
	}
/*Right*/
	.modal.right.fade .modal-dialog {
		right: 0px;
		-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
		   -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
		     -o-transition: opacity 0.3s linear, right 0.3s ease-out;
		        transition: opacity 0.3s linear, right 0.3s ease-out;
	}

	.modal.right.fade.in .modal-dialog {
		right: 0;
	}

/* ----- MODAL STYLE ----- */
	.modal-content {
		border-radius: 0;
		border: none;
	}

	.modal-header {
		border-bottom-color: #EEEEEE;
		background-color: #FAFAFA;
	}

/* ----- v CAN BE DELETED v ----- */
body {
	background-color: #78909C;
}

.demo {
	padding-top: 60px;
	padding-bottom: 110px;
}

.btn-demo {
	margin: 15px;
	padding: 10px 15px;
	border-radius: 0;
	font-size: 16px;
	background-color: #FFFFFF;
}

.btn-demo:focus {
	outline: 0;
}


</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light" style="background-color:#4A67B2;">
        <!-- Left navbar links -->
        <ul class="navbar-nav" >
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars text-white"></i></a>
            </li>
            <li class="p-2 text-white">Dashboard ({{date('d-M-Y')}})</li>
        </ul>
        
        <!-- Right navbar links -->
              <ul class="navbar-nav ml-auto">


           <!-- Messages Dropdown Menu -->

           <!-- Notifications Dropdown Menu -->
            @if(auth()->check() and auth()->user()->type === 'restaurant')
            <li class="nav-item dropdown">
               <a class="nav-link"data-toggle="modal" data-target="#myModal2" href="#">
                   <i class="fas fa-bell text-white"></i>
                   <span class="badge badge-warning navbar-badge" id="notiBell"></span>
                </a>
            </li>
            <li>
            @endif 
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <span class="text-white">{{auth()->user()->name}}</span>
                    <!--<img src="{{asset('images/user3-128x128.jpg')}}"class="brand1-image mx-2  elevation-2" alt="foodage">-->
                </a>
               <div class="dropdown-menu dropdown-menu-right mr-3">


                   <a href="#" class="dropdown-item">
                       <i class="fas fa-user mr-2"></i>Profile

                   </a>
                   <div class="dropdown-divider"></div>
                   <a href="{{ route('logout') }}" class="dropdown-item">
                       <i class="fas fa-envelope mr-2"></i> Logout

                   </a>

               </div>
           </li>

       </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{url('/admin')}}" class="brand-image p-0" style="background-color:#fff">
            <img src="{{asset('frontend/images/BuntuDelice.png')}}" alt="Logo"
                 class="brand-image"
                 style="opacity: .8; width:250px; height:50px;">
            <!--<span class="brand-text  text-white" >Chutoro</span>-->
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth()->user()->image ? url('images/profile_images/' . auth()->user()->image) : url('assets/images/user-avatar.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><b>{{auth()->user()->name}}</b></a>
                </div>
            </div> 
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                @if(auth()->check() and auth()->user()->type === 'admin')
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                        <li class=" nav-item">
                            <a class="nav-link  @yield('dashboard_nav')" href="{{url('/admin')}}">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item has-treeview @yield('order_nav_open')">
                            <a href="#" class="nav-link @yield('order_nav')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Orders
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('admin.all_orders')}}" class="nav-link @yield('order_nav_all')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Orders ({{ \App\Order::all()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.pending_orders')}}" class="nav-link @yield('pendding_order_nav')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>New Orders ({{ \App\Order::whereStatus('pending')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.complete_orders')}}" class="nav-link  @yield('order_nav_complete')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Completed ({{ \App\CompletedOrder::whereStatus('completed')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.cancel_orders')}}" class="nav-link  @yield('order_nav_cancel')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cancel ({{ \App\Order::whereStatus('cancelled')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview @yield('add_restaurant_open_nav')">
                            <a href="#" class="nav-link @yield('add_restaurant_nav')">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Restaurant
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('restaurant.index') }}" class="nav-link @yield('add_restaurant_all_nav')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Restaurant</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.pending')}}" class="nav-link @yield('add_restaurant_pending_nav')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending Requests</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('restaurant.create') }}" class="nav-link @yield('add_restaurant_create_nav')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Restaurant</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview @yield('cuisine_nav_open')">
                            <a href="#" class="nav-link @yield('cuisine_nav')">
                                <i class="nav-icon fas fa-hamburger"></i>
                                <p>
                                    Cuisine
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('cuisine.index')}}" class="nav-link @yield('cuisine_nav_all')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Cuisines</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('cuisine.create')}}" class="nav-link @yield('cuisine_nav_add')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Cuisine</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item has-treeview @yield('news_nav_open')">
                            <a href="#" class="nav-link @yield('news_nav')">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    News
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('news.index')}}" class="nav-link @yield('news_nav_all')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All News</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('news.create')}}" class="nav-link @yield('news_nav_add')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add News</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item had-treeview">
                            <a class="nav-link @yield('charge_nav')" href="{{route('charge.index')}}">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Charges
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item has-treeview @yield('driver_nav_open')">
                            <a href="#" class="nav-link @yield('driver_nav')">
                                <i class="nav-icon fas fa-taxi"></i>
                                <p>
                                    Drivers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('driver.index') }}" class="nav-link @yield('driver_nav_all')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Drivers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('driver.create') }}" class="nav-link @yield('driver_nav_add')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Drivers</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        
                        <li class="nav-item has-treeview @yield('payout_nav_open')">
                            <a href="#" class="nav-link @yield('payout_nav')">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Payout
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('restaurant_payout')}}" class="nav-link @yield('payout_nav_restaurant')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Restaurant Payout</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('driver_payout')}}" class="nav-link @yield('payout_nav_driver')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Driver Payout</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class=" nav-item has-treeview">
                            <a class="nav-link @yield('user_nav')"  href="{{ route('user.index') }}">
                                <i class="nav-icon fas fa-users "></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a class="nav-link @yield('profile_nav')" href="{{ route('admin.profile') }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class=" nav-item has-treeview">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    @elseif(auth()->check() and auth()->user()->type === 'restaurant' and auth()->user()->restaurant()->first()->services === 'both')
                        <li class="nav-item">
                            <a class="nav-link @yield('dashboard_nav')" href="{{url('restaurant')}}">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link @yield('category_nav')">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Category
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('category.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('category.create')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Category</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--<li class="nav-item has-treeview">-->
                        <!--    <a href="{{route('add-on.index')}}" class="nav-link @yield('add_on_nav')">-->
                        <!--         <i class="nav-icon fas fa-puzzle-piece"></i>-->
                        <!--        <p>Add ons</p>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="nav-item has-treeview @yield('vouchers_nav_open')">
                            <a href="" class="nav-link @yield('vouchers_nav')">
                                 <i class="nav-icon fas fa-tags"></i>
                                <p>Vouchers<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('voucher.index')}}" class="nav-link @yield('vouchers_nav_index')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Voucher</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('voucher.create')}}" class="nav-link @yield('vouchers_nav_create')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ADD Voucher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link @yield('product_nav')">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Product
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('product.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('product.create')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Product</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview @yield('order_nav_open')">
                            <a href="#" class="nav-link @yield('order_nav')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Orders
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('restaurant.all_orders')}}" class="nav-link @yield('order_nav_all')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>New Orders ({{ \App\Order::where('restaurant_id', auth()->user()->restaurant()->first()->id)->whereStatus('pending')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('restaurant.getpreparing')}}" class="nav-link @yield('order_nav_preparing')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prepairing ({{ \App\Order::where('restaurant_id', auth()->user()->restaurant()->first()->id)->whereStatus('prepairing')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('restaurant.pending_orders')}}" class="nav-link @yield('order_nav_pending')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Assigned ({{ \App\Order::where('restaurant_id', auth()->user()->restaurant()->first()->id)->whereStatus('assign')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('restaurant.complete_orders')}}" class="nav-link @yield('order_nav_complete')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Completed ({{ \App\CompletedOrder::where('restaurant_id', auth()->user()->restaurant()->first()->id)->whereStatus('completed')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('restaurant.cancel_orders')}}" class="nav-link @yield('order_nav_cancel')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cancel ({{ \App\Order::where('restaurant_id', auth()->user()->restaurant()->first()->id)->whereStatus('cancelled')->get()->unique('order_no')->count() }})</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                             <a class=" nav-link @yield('earnings_nav')" href="{{route('r_earnings.index')}}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Payment History</p>
                            </a>
                        </li>
                        <!--<li class="nav-item has-treeview">-->
                        <!--    <a href="#" class="nav-link @yield('working_hour_nav')">-->
                        <!--        <i class="nav-icon fas fa-calendar-times"></i>-->
                        <!--        <p>-->
                        <!--            Working Hours-->
                        <!--            <i class="right fas fa-angle-left"></i>-->
                        <!--        </p>-->
                        <!--    </a>-->
                        <!--    <ul class="nav nav-treeview">-->
                        <!--        <li class="nav-item">-->
                        <!--            <a href="{{route('working_hour.index')}}" class="nav-link">-->
                        <!--                <i class="far fa-circle nav-icon"></i>-->
                        <!--                <p>List</p>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--        <li class="nav-item">-->
                        <!--            <a href="{{route('working_hour.create')}}" class="nav-link">-->
                        <!--                <i class="far fa-circle nav-icon"></i>-->
                        <!--                <p>Add</p>-->
                        <!--            </a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</li>-->
{{--                        <li class=" nav-link">--}}
{{--                            <a href="{{ route('profile') }}">--}}
{{--                                <i class="nav-icon fas fa-user"></i>--}}
{{--                                <p>--}}
{{--                                    Profile--}}
{{--                                    --}}{{-- <i class="right fas fa-angle-left"></i>--}}
{{--                                </p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <!--<li class="nav-item ">-->
                        <!--    <a class="nav-link " href="{{ route('delivery_boundary') }}">-->
                        <!--        <i class="nav-icon fas fa-map-marker"></i>-->
                        <!--        <p>-->
                        <!--            Delivery Boundary-->
                        <!--        </p>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class=" nav-item">
                            <a class=" nav-link" href="{{ route('logout') }}">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    LogOut
                                </p>
                            </a>
                        </li>

                     @elseif(auth()->check() and auth()->user()->type === 'restaurant' and auth()->user()->restaurant()->first()->services === 'delivery')
                     <!-- Here starts the delivery nav-bar -->
                        <li class="nav-item">
                            <a class="nav-link @yield('dashboard_nav')" href="#">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                       <li class="nav-item has-treeview">
                            <a href="#" class="nav-link @yield('order_nav')">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Orders
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('delivery.all_orders')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Orders</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('delivery.complete_orders')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Completed</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('delivery.cancel_orders')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cancel</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('delivery.pending_orders')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pending</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('delivery.schedule_orders')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Scheduled</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                             <a class=" nav-link @yield('earnings_nav')" href="">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Payment History
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('d_earnings.index')}}" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Total Earnings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('d_earnings.create')}}" class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Payment History</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" nav-item">
                            <a class=" nav-link" href="{{ route('logout') }}">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    LogOut
                                </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @yield('content')
    </div>
</div>
<footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="#">Buntu Delice</a>.</strong>
    All rights reserved.
</footer>
</div><!-- container -->

<!-- Notification panel -->

<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content pb-5">

            <div class="modal-header p-3">
                <h4 class="modal-title" id="notiTitle"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" style="float:left"><i class="fas fa-arrow-right" style="margin-top:5px;"></i></span></button>
            </div>
            <div class="modal-body p-0 mb-5" id="notiBody">                   
            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset(env('ASSET_URL') .'plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset(env('ASSET_URL') .'plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset(env('ASSET_URL') .'plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset(env('ASSET_URL') .'plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset(env('ASSET_URL') .'plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset(env('ASSET_URL') .'plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset(env('ASSET_URL') .'plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset(env('ASSET_URL') .'plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{ asset(env('ASSET_URL') .'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{ asset(env('ASSET_URL') .'plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset(env('ASSET_URL') .'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset(env('ASSET_URL') .'dist/js/adminlte.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset(env('ASSET_URL') .'dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset(env('ASSET_URL') .'dist/js/demo.js')}}"></script>
@if(auth()->check() and auth()->user()->type === 'restaurant' )
<Script>

get_notification();
setInterval(get_notification, 5000);
function get_notification()
{
    var id = {{auth()->user()->restaurant->id}};
    
    $.ajax({
        type: "GET",
        url: "{{url('/')}}/restaurant/notifications/"+id,
        dataType:'json',
        success: function(data){
            var value = '';
            if(data.count > 0){
                data.orders.forEach( function(element, index) {
                    value +=` <a href="{{url('/')}}/restaurant/show_order/`+element.order_no+`" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i>`+element.order_no+`<span class="float-right text-muted text-sm">
                            `+element.time+`</span> </a> <div class="dropdown-divider"></div>`;
                });
            }else{
                value += `<a class="dropdown-item text-center">
                            <b>No New Notification</b>
                          </a> <div class="dropdown-divider"></div>`;
            }
            document.getElementById('notiBody').innerHTML = value;
            document.getElementById('notiTitle').innerHTML = data.count + ' Notifications';
            document.getElementById('notiBell').innerHTML = data.count ;
            if(data.new){
                document.getElementById('myAudio').play();
            }
        }  
    });
  
}
</Script>
@endif
@yield('script')
</body>
</html>
