@extends('layouts.app')
@section('title', 'Set Driver Pay | Buntu Delice ')
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
                        <li class="breadcrumb-item "><a href="{{route('driver.index')}}">Driver</a></li>
                        <li class="breadcrumb-item active">Add Pay</li>
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
                            <h3 class="card-title">Update Driver</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('admin.set_hourly_pay',$driver->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="hourly_pay">Hourly Pay</label>
                                    <input type="text" value="{{old('hourly_pay')}}" name="hourly_pay"
                                           class="form-control{{ $errors->has('hourly_pay') ? ' is-invalid' : ''}}" id="hourly_pay"
                                           placeholder="Enter ">
                                    @if($errors->has('hourly_pay'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('hourly_pay') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a   style="float:right; margin:0 5px;" href="{{ route('driver.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
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
