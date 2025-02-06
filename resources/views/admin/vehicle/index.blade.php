@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('vehicle_nav', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vehicles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vehicles</li>
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
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-2">
                            <table class="table table-head-fixed text-nowrap" id="example1">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Model</th>
                                    <th>Registration Number</th>
                                    <th>License Number</th>
                                    <th>Color</th>
                                    <th>Driver</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $vehicles as $index => $vehicle)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{$vehicle->model}}</td>
                                        <td>{{$vehicle->number}}</td>
                                        <td>{{$vehicle->license_number}}</td>
                                        <td>{{$vehicle->color}}</td>
                                        <td>{{$vehicle->driver->name}}</td>
                                        <td>
                                            <a href="{{ route('vehicle.edit', $vehicle->id) }}"
                                               class="btn btn-outline-info">Edit</a>
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                Delete
                                                <form action="{{ route('vehicle.destroy', $vehicle->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this vehicle?');">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>
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