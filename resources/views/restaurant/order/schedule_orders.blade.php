@extends('layouts.app')
@section('title','Scheduled order')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('order_nav', 'active')
@section('order_nav_open', 'menu-open')
@section('order_nav_scheduled', 'active')

@section('content')
<div class="content-header">
    @if(session()->has('alert'))
    <div class="alert alert-{{ session()->get('alert.type') }}">
        {{ session()->get('alert.message') }}
    </div>
    @endif
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Scheduled Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Scheduled Orders</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Schedule Orders</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                       placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-2">
                        <table class="table table-head-fixed text-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <!--<th>Customer Name</th>-->
                                <th>Restaurant Name</th>
                                <th>Cost</th>
                                <th>Scheduled Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $index => $order)
                            <tr>
                                <td>{{++$index}}</td>
                                <!--<td>{{$order->user->name}}</td>-->
                                <td>{{$order->restaurant->name}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->scheduled_date}}</td>
                                <td>{{$order->status}}</td>
                                <td>
                                   <a href="{{route('admin.show_order',$order)}}" class="btn btn-outline-warning"title="view"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{asset(env('ASSET_URL') .'plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset(env('ASSET_URL') .'plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable();
  
    });
  </script>
@endsection