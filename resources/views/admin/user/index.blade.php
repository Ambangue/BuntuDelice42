@extends('layouts.app')
@section('title', 'Users | Buntu Delice')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('user_nav', 'active')

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
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $index=> $user)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td><img src="@if($user->image) {{ asset(env('ASSET_URL') .'images/profile_images/'. $user->image) }} @else {{ asset(env('ASSET_URL') .'images/profile_images/'. '5-512.png') }} @endif" class="img-circle elevation-2"
                                                 alt="Image" width="50"></td>
                                        <td>{{$user->phone}}</td>
                                        <td>
                                            <a href="{{ route('admin.change_block_status', $user->id) }}">
                                                <span class="badge badge-{{ $user->blocked ? 'danger' : 'success' }}">{{ $user->blocked ? 'Blocked' : 'Active' }}</span>
                                            </a>
                                        </td>
                                        
                                        
                                        
                                        
                                        
                                        <td>
<!--{{--                                            <li class="nav-item">--}}-->
<!--{{--                                                <a href="{{ route('admin.set_hourly_pay') }}" class="nav-link">--}}-->
<!--{{--                                                    <i class="far fa-circle nav-icon"></i>--}}-->
<!--{{--                                                    <p>Add Hourly Pay</p>--}}-->
<!--{{--                                                </a>--}}-->
<!--{{--                                            </li>--}}-->
{{--                                            <button class="btn btn-default">View</button>--}}
                                            <!--<a href="{{ route('admin.get_hourly_pay', $user->id) }}"-->
                                            <!--   class="btn btn-outline-primary btn-sm">Add Pay</a>-->
                                            <!--<a href="{{ route('driver.edit', $user->id) }}"-->
                                            <!--   class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>-->
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                                <form action="{{ route('user.destroy', $user->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this driver?');">
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
