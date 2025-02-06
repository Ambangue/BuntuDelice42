@extends('layouts.app')
@section('title','Optional/Required')
@section('product_nav', 'active')
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
                    <h1 class="m-0 text-dark">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Products</a></li>
                        <li class="breadcrumb-item active">Add on</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-optional-tab" data-toggle="pill" href="#custom-tabs-three-optional" role="tab" aria-controls="custom-tabs-three-optional" aria-selected="true">Optionals</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-required-tab" data-toggle="pill" href="#custom-tabs-three-required" role="tab" aria-controls="custom-tabs-three-required" aria-selected="false">Required</a>
                              </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-optional" role="tabpanel" aria-labelledby="custom-tabs-three-optional-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card shadow">
                                                <div class="card-header">
                                                    <h3>Optional AddOns</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="">
                                                        <img class="d-inline rounded" width="50" src="../../images/product_images/{{$prod->image}}">
                                                        <p class="d-inline"><span><b>Name:</b></b></span>{{$prod->name}}</p>
                                                    </div>
                                                    <br>
                                                    <form method="post" role="form" action="{{ route('optional.store') }}" >
                                                        @csrf
                                                            
                                                                <input type="hidden" name="product_id" value="{{$prod->id}}">
                                                                
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-12 col-xs-12">
                                                                <select required class="form-control" name="add_on_title_id">
                                                                    <option selected value="">Select Add on Title</option>
                                                                    @foreach($addons as $index => $data)
                                                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-6 col-xs-12">
                                                                <input required class="form-control" type="text" name="title" placeholder="Enter Optional title" value=""/>
                                                            </div>
                                                            <div class="form-group col-sm-6 col-xs-12">
                                                                <input required class="form-control" type="text" name="price" placeholder="Enter the price" value=""/>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn bg-gradient-info">Add</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card shadow">
                                                <div class="card-header">
                                                    <h3>All Optionals</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table id="example1" class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th>Add on Title</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($optional as $index => $data)
                                                            <tr>
                                                                <form method="post" action="{{route('optional.update' , $data->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <td>{{++$index}}</td>
                                                                    <td><input class="border-0 w-75" type="text" name="title" value="{{$data->title}}" /></td>
                                                                    <td><input class="border-0 w-50" type="text" name="price" value="{{$data->price}}" /></td>
                                                                    <td><input class="border-0 w-75" type="text" name="add_on_title_id" value="{{$data->add_on_title_id}}" /></td>
                                                                    <td>
                                                                        <button type="submit" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></button>
                                                                    </form>
                                                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-sm btn-outline-danger">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                            <form action="{{ route('optional.destroy', $data->id) }}"
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-required" role="tabpanel" aria-labelledby="custom-tabs-three-required-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card shadow">
                                                <div class="card-header">
                                                    <h3>Required AddOns</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="">
                                                        <img class="d-inline rounded" width="50" src="../../images/product_images/{{$prod->image}}">
                                                        <p class="d-inline"><span><b>Name:</b></b></span>{{$prod->name}}</p>
                                                    </div>
                                                    <br>
                                                    <form method="post" role="form" action="{{ route('required.store') }}"enctype="multipart/form-data">
                                                        @csrf
                                                            
                                                                <input type="hidden" name="product_id" value="{{$prod->id}}">
                                                                
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-12 col-xs-12">
                                                                <select required class="form-control" name="add_on_title_id">
                                                                    <option selected value="">Select Add on Title</option>
                                                                    @foreach($addons as $index => $data)
                                                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-6 col-xs-12">
                                                                <input required class="form-control" type="text" name="title" placeholder="Enter required title" value=""/>
                                                            </div>
                                                            <div class="form-group col-sm-6 col-xs-12">
                                                                <input required class="form-control" type="text" name="price" placeholder="Enter the required price" value=""/>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn bg-gradient-info">Add</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card shadow">
                                                <div class="card-header">
                                                    <h3>All Required</h3>
                                                </div>
                                                <div class="card-body table-responsive">
                                                    <table id="example11" class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th>Add on Title</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($required as $index => $data)
                                                            <tr>
                                                                <form method="post" action="{{route('required.update' , $data->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <td>{{++$index}}</td>
                                                                    <td><input class="border-0 w-75" type="text" name="title" value="{{$data->title}}" /></td>
                                                                    <td><input class="border-0 w-50" type="text" name="price" value="{{$data->price}}" /></td>
                                                                    <td><input class="border-0 w-75" type="text" name="add_on_title_id" value="{{$data->add_on_title_id}}" /></td>
                                                                    <td>
                                                                        <button type="submit" class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i></button>
                                                                    </form>
                                                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-sm btn-outline-danger">
                                                                            <i class="fa fa-trash-alt"></i>
                                                                            <form action="{{ route('required.destroy', $data->id) }}"
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
                                            </div>
                                        </div>
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
<script>
    $(function () {
      $("#example1").DataTable();
      $("#example11").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
    });
  </script>
@endsection
