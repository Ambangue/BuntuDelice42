@extends('layouts.app')
@section('title','Categories')
@section('category_nav', 'active')

@section('title', 'Category')
@section('style')
<link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">
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
                    <h1 class="m-0 text-dark">All Categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                        <div class="card-body">
                            <label>Add Your Category</label>
                            <form class="form-inline justify-content-center" role="form" method="post" action="{{ isset($category) ? route('category.update',$category->id) : route('category.store') }}"  enctype="multipart/form-data">
                                @csrf
                                @if (isset($category))
                                @method('PUT')
                                @endif
                                <div class="form-group">
                                    <input required name="name" id="name" type="text"  value="{{ isset($category) ? $category->name : '' }}" class="rounded-0 form-control {{ $errors->has('name') ? ' is-invalid' : ''}}" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="rounded-0 btn btn-default">Add</button>
                                </div>
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Categories</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive ">
                            <table  id="example1" class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $index=> $category)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->created_at}}</td>
                                        <td>
                                            <a href="{{ route('category.edit', $category->id) }}"
                                               class="btn btn-outline-info"><i class="fa fa-pen"></i></a>
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                                <form action="{{ route('category.destroy', $category->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this category?');">
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
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
{{-- <script type="text/javascript">
    @if (Session::has('success'))
    toastr.success("{{Session::get('success')}}");
    @endif
</script> --}}
<script>
    $(function () {
      $("#example1").DataTable();
    
    });
  </script>
@endsection
