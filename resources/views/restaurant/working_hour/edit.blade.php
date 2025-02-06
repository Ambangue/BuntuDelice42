@extends('layouts.app')
@section('working_hour_nav', 'active')
@section('title', 'Category')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Working Hours</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('working_hour.index')}}">Working Hours</a></li>
                        <li class="breadcrumb-item active">Update</li>
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
                            <h3 class="card-title">Update Working Hours</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('working_hour.update',$workingHour->id) }}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group ">
                                    <label for="day">Day</label>
                                    <input type="text" value="{{$workingHour->Day}}"
                                           class="form-control {{ $errors->has('day') ? ' is-invalid' : ''}}"
                                           name="day" id="day" placeholder="Enter"/>
                                    @if($errors->has('day'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('day') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group ">
                                    <label for="opening_time">Opening Hour</label>
                                    <input type="text" value="{{$workingHour->opening_time}}"
                                           class="form-control {{ $errors->has('opening_time') ? ' is-invalid' : ''}}"
                                           name="opening_time" id="opening_time" placeholder="Enter"/>
                                    @if($errors->has('opening_time'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('opening_time') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="form-group ">
                                    <label for="closing_time">Closing Hour</label>
                                    <input type="text" value="{{$workingHour->closing_time}}"
                                           class="form-control {{ $errors->has('closing_time') ? ' is-invalid' : ''}}"
                                           name="closing_time" id="closing_time" placeholder="Enter"/>
                                    @if($errors->has('closing_time'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('closing_time') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a style="float:right; margin:0 5px;" href="{{ route('working_hour.index') }}"
                                       class="btn btn-secondary btn-sm">Cancel</a>
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
