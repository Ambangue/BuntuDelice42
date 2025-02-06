@extends('layouts.app')
@section('title', 'Create News | Buntu Delice')
@section('news_nav', 'active')
@section('news_nav_open', 'menu-open')
@section('news_nav_add', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Cuisine</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('cuisine.index')}}">Cuisine</a></li>
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
                            <h3 class="card-title">Add News</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('news.store') }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" value="{{old('title')}}" name="title"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" id="title"
                                           placeholder="Enter new News">
                                    @if($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Description</label>
                                    <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : ''}}" name="description"></textarea>
                                    @if($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a   style="float:right; margin:0 5px;" href="{{ route('cuisine.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
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
