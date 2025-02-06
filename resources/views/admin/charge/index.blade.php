@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('charge_nav', 'active')

@section('title', 'Add Charges')

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
                <h1 class="m-0 text-dark">All Charges</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    @if(!$charge)
                      <li class="breadcrumb-item " ><a href="{{route('charge.index')}}">Charges</a></li>
                      <li class="breadcrumb-item active">Add</li>
                    @else
                      <li class="breadcrumb-item active">Charges</li>
                    @endif
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-11">
        @if(!$charge)
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card ">
              <div class="card-header text-center">
                <h4><b>Add Your Charges</b></h4>
              </div>
              <div class="card-body">
                <form role="form" method="post" action="{{route('charge.store')}}">
                  @csrf
                  <div class="form-group">
                    <label for="service_fee">Service Charges</label>
                    <input type="text" class="form-control" name="service_fee" id="service_fee" />
                  </div>
                  <div class="form-group">
                    <label for="tax">Tax </label>
                    <input type="text" class="form-control" name="tax" id="tax" />
                  </div>
                  <div class="form-group">
                    <label for="delivery_fee">Delivery Charges</label>
                    <input type="text" class="form-control" name="delivery_fee" id="delivery_fee" />
                  </div>
                  <div class="form-group">
                    <label for="delivery_fee">Pickup Fee</label>
                    <input type="text" class="form-control" name="pickup_fee" id="pickup_fee" />
                  </div>
                  <div class="form-group">
                    <button type="reset" class="btn bg-gradient-info">Cancel</button>
                    <button type="submit" class="btn bg-gradient-danger">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5 align-self-center ">
            <div class="card py-5">
              <div class="card-body my-4">
                <img class="w-100" src="{{asset(env('ASSET_URL') .'images/banner-in-gif.gif')}}" />
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header text-center">
                <h3><b>Charges Management</b></h3>
              </div>
              <div class="card-body table-responsive">
                <table id="example1" class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Service Charges%</th>
                      <th>Tax%</th>
                      <th>Delivery Charges &#36;</th>
                      <th>Pickup Fee</th>
                      <th>Updated At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <form role="form" method="post" action="{{route('charge.update',$charge)}}"> 
                        @csrf
                        @method('PUT')
                        <td>1</td>
                        <td><input class="border-0" type="text" name="service_fee" value="{{$charge->service_fee}}" /></td>
                        <td><input class="border-0" type="text" name="tax" value="{{$charge->tax}}" /></td>
                        <td><input class="border-0" type="text" name="delivery_fee" value="{{$charge->delivery_fee}}"/></td>
                        <td><input class="border-0" type="text" name="pickup_fee" value="{{$charge->pickup_fee}}"/></td>
                        <td>{{$charge->updated_at}}</td>
                        <td>
                          <button type="submit" class="btn btn-outline-warning btn-sm">Update</button>
                      </form>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        @endif
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
