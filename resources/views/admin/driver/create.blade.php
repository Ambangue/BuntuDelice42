@extends('layouts.app')
@section('title', 'Create New Driver | Buntu Delice ')
@section('driver_nav', 'active')
@section('driver_nav_open', 'menu-open')
@section('driver_nav_add', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Drivers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('driver.index')}}">Drivers</a></li>
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
                            <h3 class="card-title ">Add Driver</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('driver.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="qr-el qr-el-3"
                                             style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03); padding:25px; margin:0px 20px;">
                                            <label for="file-input" class="hoviringdell uploadBox" id="uploadTrigger"
                                                   style="height: 110px; text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                <img src="" style="width: 90px;" id="logo" alt="license">
                                                <div class="uploadText" style="font-size: 12px;">
                                                    <span style="color:#F69518;">Upload License Image</span><br>
                                                    Size 90x90
                                                </div>
                                            </label>
                                            <input type="file" id="file-input" name="licence_image"
                                                   onchange="logo1(this);">
                                            @if($errors->has('licence_image'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('licence_image') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="qr-el qr-el-3"
                                             style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03); padding:25px; margin:0px 20px;">
                                            <label for="upload_file" class="hoviringdell uploadBox"
                                                   id="uploadTrigger"
                                                   style="height: 110px; text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                <img src="" style="width: 180px;" id="cover" alt="image">
                                                <div class="uploadText" style="font-size: 12px;">
                                                    <span style="color:#F69518;">Upload Profile Image</span><br>
                                                    Size 320x220
                                                </div>
                                            </label>
                                            <input type="file" id="upload_file" name="image" onchange="cover1(this);">
                                            @if($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group ">
                                    <h4 style="text-align:center; padding:10px; margin-top:50px;"
                                        class="text-light bg-dark">
                                        Driver Information
                                    </h4>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{old('name')}}"
                                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               id="name" placeholder="">
                                        @if($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" value="{{old('email')}}"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               id="email" placeholder="">
                                        @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pass">Password</label>
                                        <input type="password" name="password"
                                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               id="pass" placeholder="">
                                        @if($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" value="{{old('phone')}}"
                                               class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                               id="phone">
                                        @if($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" value="{{old('address')}}"
                                               class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                               id="address" placeholder="">
                                        @if($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <h4 style="text-align:center; padding:10px; margin-top:50px;"
                                        class="text-light bg-dark">
                                        Bank Details
                                    </h4>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="account_name">Account Name</label>
                                        <input type="text" value="{{old('account_name')}}"
                                               class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}"
                                               id="account_name" name="account_name" placeholder="">
                                        @if($errors->has('account_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="account_number">Account Number</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}"
                                               id="account_number" name="account_number" placeholder="">
                                        @if($errors->has('account_number'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" value="{{old('bank_name')}}"
                                               class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
                                               id="bank_name" name="bank_name" placeholder="">
                                        @if($errors->has('bank_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="branch_name">Branch Number</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('branch_name') ? ' is-invalid' : '' }}"
                                               id="branch_name" name="branch_name" placeholder="">
                                        @if($errors->has('branch_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('branch_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="branch_address">Branch Address</label>
                                        <input type="text" value="{{old('branch_address')}}"
                                               class="form-control {{ $errors->has('branch_address') ? ' is-invalid' : '' }}"
                                               id="branch_address" name="branch_address" placeholder="">
                                        @if($errors->has('branch_address'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('branch_address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a   style="float:right; margin:0 5px;" href="{{ route('driver.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm"
                                        style="float:right;">Add
                                </button>
                            </div>
                            @csrf
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
