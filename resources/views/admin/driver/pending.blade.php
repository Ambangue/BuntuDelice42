@extends('layouts.app')

@section('title', 'Pendings Driver | Buntu Delice ')
@section('driver_nav', 'active')
@section('driver_nav_open', 'menu-open')
@section('driver_nav_all', 'active')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Driver</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Driver</a></li>
                    <li class="breadcrumb-item active">Pendings</li>
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
                <h3 class="card-title">Pending Requests</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>

                      <th>Mobile</th>
                      <th>Status</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>abc@gmail.com</td>
                      <td>360 Jody Road</td>

                      <td>0303123456</td>
                      <td style="color:red;">Pending &nbsp;<i class="far fa-clock" aria-hidden="true"></i></td>
                      <td>
                      <button class="btn btn-default">View</button>
                  <button class="btn btn-primary">Edit</button>
                  <button class="btn btn-danger">Delete</button>

                     </td>

                    </tr>
                    <tr>

                    <td>183</td>
                      <td>John Doe</td>
                      <td>abc@gmail.com</td>
                      <td>360 Jody Road</td>

                      <td>0303123456</td>
                      <td style="color:red;">Pending &nbsp;<i class="far fa-clock" aria-hidden="true"></i></td>
                      <td>
                      <button class="btn btn-default">View</button>
                  <button class="btn btn-primary">Edit</button>
                  <button class="btn btn-danger">Delete</button>

                     </td>
                    </tr>
                    <tr>

                    <td>183</td>
                      <td>John Doe</td>
                      <td>abc@gmail.com</td>
                      <td>360 Jody Road</td>

                      <td>0303123456</td>
                      <td style="color:red;">Pending &nbsp;<i class="far fa-clock" aria-hidden="true"></i></td>
                      <td>
                      <button class="btn btn-default">View</button>
                  <button class="btn btn-primary">Edit</button>
                  <button class="btn btn-danger">Delete</button>

                     </td>
                    </tr>


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
