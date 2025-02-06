@extends('layouts.app')
@section('title', 'News From Admin')
@section('news_nav', 'active')
@section('news_nav_open', 'menu-open')
@section('news_nav_all', 'active')

@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
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
                <h1 class="m-0 text-dark">All News</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">News</li>
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
          <div class="card-body table-responsive pt-2" >
            <table class="table table-head-fixed text-nowrap" id="example1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
              @foreach($news as $index=> $cuisine)
                  <tr>
                      <td>{{++$index}}</td>
                      <td>{{$cuisine->title}}</td>
                      <td>{{$cuisine->description}}</td>
                      <td>{{$cuisine->created_at}}</td>
                      <td>
                          <a href="{{ route('news.edit', $cuisine->id) }}"
                             class="btn btn-sm btn-outline-info"><i class="far fa-edit"></i></a>
                          <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                             class=" btn btn-sm btn-danger">
                             <i class="fas fa-trash-alt"></i>
                              <form action="{{ route('news.destroy', $cuisine->id) }}"
                                    method="post"
                                    onsubmit="return confirm('Do you really want to delete this cuisine?');">
                                  @csrf
                                  @method('delete')
                              </form>
                          </a>
                          <a href="{{ route('send.notification', $cuisine->id) }}"
                             class="btn btn-sm btn-outline-info"><i class="fas fa-bell"></i></a>
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
