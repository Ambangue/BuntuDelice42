@extends('layouts.app')
@section('restaurant_nav', 'active')

@section('title', 'Restaurant')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Restaurant</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('restaurant.index')}}">Restaurant</a></li>
                        <li class="breadcrumb-item active">Add Service Charges</li>
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
                            <h3 class="card-title">Add Service Charges</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.set_service_charges',$restaurant->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="services">Services Used By Restaurant</label>
                                    <input type="text" value="{{$restaurant->services}}" name="services"
                                           class="form-control{{ $errors->has('services') ? ' is-invalid' : ''}}" id="services"
                                           placeholder="Enter ">
                                    @if($errors->has('services'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('services') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="service_charges">Service Charges</label>
                                    <input type="text" value="{{old('service_charges')}}" name="service_charges"
                                           class="form-control{{ $errors->has('service_charges') ? ' is-invalid' : ''}}" id="service_charges"
                                           placeholder="Enter ">
                                    @if($errors->has('service_charges'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('service_charges') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a   style="float:right; margin:0 5px;" href="{{ route('restaurant.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="float:right;">Update
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
