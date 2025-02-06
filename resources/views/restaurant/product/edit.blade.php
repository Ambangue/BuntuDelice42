@extends('layouts.app')
@section('title','Edit Product')
@section('food_nav', 'active')
@section('style')
    <link rel="stylesheet"
          href="{{ asset(env('ASSET_URL') .'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset(env('ASSET_URL') .'plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <link rel="stylesheet" href="{{ asset(env('ASSET_URL') .'plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset(env('ASSET_URL') .'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .note-table, .note-insert {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('product.index')}}">Products</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Update Product</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <form role="form" method="post" action="{{ route('product.update',$product->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="name" id="name" value="{{$product->name}}"
                                                   placeholder="Name"/>
                                            @if($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="price">Price</label>
                                                <input type="text" value="{{$product->price}}"
                                                       class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }} "
                                                       name="price" id="price"
                                                       placeholder="price"/>
                                                @if($errors->has('price'))
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="discount_price">DiscountPrice</label>
                                                <input type="text" value="{{$product->discount_price}}"
                                                       class="form-control {{ $errors->has('discount_price') ? ' is-invalid' : '' }} "
                                                       name="discount_price"
                                                       id="discount_price"/>
                                                @if($errors->has('discount_price'))
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount_price') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label for="select">Category</label>
                                            <select id="select" name="category_id"
                                                    class="form-control">
                                                <option value="">Choose...</option>
                                                @foreach(\App\Category::all() as $category)
                                                    <option
                                                        value="{{$category->id}}"@if ($category->id==$product->category_id) selected @endif>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6" data-select2-id="40">
                                        <div class="form-group col-md-12">
                                            <div class="qr-el qr-el-3"
                                                 style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03); padding:25px; margin:0px 20px;">
                                                <label for="file-input" class="hoviringdell uploadBox"
                                                       id="uploadTrigger"
                                                       style="height: 110px; text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                    <img src="{{url('images/product_images',$product->image)}}" style="width: 100px;" id="logo" alt="image">
                                                    <div class="uploadText" style="font-size: 12px;">
                                                        <span style="color:#F69518;">Upload Image</span><br>
                                                        Size 90x90
                                                    </div>
                                                </label>
                                                <input type="file" id="file-input"
                                                       class="form-control {{ $errors->has('image') ? ' is-invalid' : ''}}"
                                                       name="image" onchange="logo1(this);">
                                                @if($errors->has('image'))
                                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="size">Weight</label>
                                            <input type="text" value="{{$product->size}}"
                                                   class="form-control {{ $errors->has('size') ? ' is-invalid' : '' }} "
                                                   name="size" id="size"/>
                                            @if($errors->has('size'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('size') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row">
                                    
                                        <div class="form-group col-12">
                                            <label for="description">Description</label>
                                            <div class="card-body p-0">
                                                <div class="mb-3">
                                                    <textarea
                                                        class="textarea form-control {{ $errors->has('description') ? ' is-invalid' : ''}}"
                                                        placeholder="Place some text here"
                                                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                                        id="description" name="description">{{$product->description}}</textarea>
                                                        @if($errors->has('description'))
                                                            <span class="invalid-feedback" role="alert">
                                                                  <strong>{{ $errors->first('description') }}</strong>
                                                              </span>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a style="float:right; margin:0 5px;" href="{{ route('product.index') }}"
                                   class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="float:right;">Update
                                </button>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset(env('ASSET_URL') .'plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset(env('ASSET_URL') .'plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script
        src="{{ asset(env('ASSET_URL') .'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <script
        src="{{ asset(env('ASSET_URL') .'plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script src="{{ asset(env('ASSET_URL') .'plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

    <script>
        function cover1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#cover')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function logo1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logo')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
