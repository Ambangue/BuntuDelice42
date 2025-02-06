@extends('layouts.app')

@section('vehicle_nav', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vehicles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('vehicle.index')}}">Vehicles</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content" style="padding: 20px; ">
        <div class="container-fluid main-content">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-primary ">
                        <div class="card-header text-center">
                            <h3 class="card-title ">Add Vehicle</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('vehicle.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <div class="qr-el qr-el-3"
                                             style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03); padding:25px; margin:0px 20px;">
                                            <label for="file_input" class="hoviringdell uploadBox" id="uploadTrigger"
                                                   style="height: 110px; text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                <img src="" style="width: 90px;" id="licence">
                                                <div class="uploadText" style="font-size: 12px;">
                                                    <span style="color:#F69518;">Driving Licence Image</span><br>
                                                </div>
                                            </label>
                                            <input type="file" id="file_input" name="license_image"
                                                   class="form-control {{ $errors->has('license_image') ? ' is-invalid' : ''}}"
                                                   onchange="licen(this);">
                                            @if($errors->has('license_image'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('license_image') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <h4 style="text-align:center; padding:10px; margin-top:50px;"
                                        class="text-light bg-dark">
                                        Vehicle Details
                                    </h4>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="license_number">Driving License Number</label>
                                        <input type="text" value="{{old('license_number')}}"
                                               class="form-control {{ $errors->has('license_number') ? ' is-invalid' : '' }}"
                                               id="license_number" name="license_number" placeholder="">
                                        @if($errors->has('license_number'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('license_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="model">Model</label>
                                        <input type="text" value="{{old('model')}}"
                                               class="form-control {{ $errors->has('model') ? ' is-invalid' : '' }}"
                                               id="model" name="model" placeholder="">
                                        @if($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="number">Vehicle Registration Number</label>
                                        <input type="text" value="{{old('number')}}"
                                               class="form-control {{ $errors->has('number') ? ' is-invalid' : '' }}"
                                               id="number" name="number" placeholder="">
                                        @if($errors->has('number'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="color">color</label>
                                        <input type="text" value="{{old('color')}}"
                                               class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}"
                                               id="color" name="color" placeholder="">
                                        @if($errors->has('color'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('color') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="driver">Driver</label>
                                        <select id="driver" class="form-control " name="driver_id">
                                            <option selected="">Choose...</option>
                                            @foreach(\App\Driver::all() as $driver)
                                                <option
                                                    value="{{$driver->id}}"{{old('driver_id') == $driver->id ? 'selected' : ''}}>{{$driver->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a style="float:right; margin:0 5px;" href="{{ route('vehicle.index') }}"
                                   class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="float:right;">Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <script>
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

        function licen(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#licence')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
