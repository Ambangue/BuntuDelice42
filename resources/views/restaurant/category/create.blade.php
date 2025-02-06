@extends('layouts.app')
@section('category_nav', 'active')
@section('title', 'Add Category')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Category</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="#">Category</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card card-primary ">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('category.store') }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group ">
                                    <label for="name">Category</label>
                                    <input type="text" value="{{old('name')}}"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : ''}}"
                                           name="name" id="name" placeholder="Enter new category"/>
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a style="float:right; margin:0 5px;" href="{{ route('category.index') }}"
                                       class="btn btn-secondary btn-sm">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-sm"
                                            style="float:right;">Add
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-->>>>>>> ff096d4b12bff8b424f347de443c0ea84fcf26cd--}}
