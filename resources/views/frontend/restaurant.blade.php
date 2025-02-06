	@extends('frontend.layouts.app')
@section('title', 'Restaurant Sign Up | Buntu Delice ')
@section('keywords','Restaurant')
@section('content') 
		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
				<h2>Sign Up <br> <span>to your account</span></h2> 
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="#"><i class="fa fa-home"></i> Home</a></li> 
			<li class="active">Sign Up</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<!-- sign up-page -->
	<div class="login-page about">
		<img class="login-m9img" src="images/img3.jpg" alt="">
		<div class="container"> 
			<h3 class="m9ls-title m9ls-title1">Sign Up to your account</h3>  
			@if(session()->has('alert'))
            <div class="alert alert-{{ session()->get('alert.type') }}" style="text-align:center;font-weight:bold;">
                {{ session()->get('alert.message') }}
            </div>
            @endif
			<div class="login-agileinfo"> 
				<form action="{{route('partner.register')}}" method="post" enctype="multipart/form-data"> 
				@csrf
					<input class="agile-ltext" type="text" value="{{old('name')}}" name="name" placeholder="Full Name" required="">
					<input class="agile-ltext" type="text" value="{{old('phone')}}" name="phone" placeholder="Phone" required="">
					<input class="agile-ltext" type="email" value="{{old('email')}}" name="email" placeholder="Your Email" required=""><br>
					<div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="qr-el qr-el-3"
                                             style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03);overflow:hidden;">
                                            <label for="upload_file" class="hoviringdell uploadBox"
                                                   id="uploadTrigger"
                                                   style="text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                <img src="{{url('images/placeholder.png')}}" style="width:180px;" id="proflie_image" alt="image">
                                                <div class="uploadText" style="font-size: 12px;">
                                                    <span style="color:#F69518;">Logo</span><br>
                                                    Size 90x90
                                                </div>
                                            </label>
                                            <input type="file" id="upload_file" name="logo" onchange="profile(this);">
                                            @if($errors->has('logo'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="qr-el qr-el-3"
                                             style="min-height: auto;  box-shadow: 2px 0px 30px 5px rgba(0, 0, 0, 0.03);overflow:hidden;">
                                            <label for="file-input" class="hoviringdell uploadBox" id="uploadTrigger"
                                                   style=" text-align:center; width:100%; border:dotted 2px #cccccc;">
                                                <img src="{{url('images/placeholder.png')}}" style="width:180px;" id="licence_image" alt="license">
                                                <div class="uploadText" style="font-size: 12px;">
                                                    <span style="color:#F69518;">Cover Image</span><br>
                                                    Size 90x90
                                                </div>
                                            </label>
                                            <input type="file" id="file-input" name="cover_image"
                                                   onchange="licenceimage(this);">
                                            @if($errors->has('cover_image'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cover_image') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
					<input class="agile-ltext" type="text" name="slogan" value="{{old('slogan')}}" placeholder="Slogan" required="">
					<input class="agile-ltext" type="text" name="account_name" value="{{old('account_name')}}" placeholder="Account Name" required="">
					<input class="agile-ltext" type="text" name="account_number" value="{{old('account_number')}}" placeholder="Account Number" required="">
					<input class="agile-ltext" type="text" name="bank_name" value="{{old('bank_name')}}" placeholder="Bank Name" required="">
					<input class="agile-ltext" type="text" name="branch_number" value="{{old('branch_number')}}" placeholder="Branch Number" required="">
					<input class="agile-ltext" type="text" name="city" value="{{old('city')}}" placeholder="City Name" required="">
					<input class="agile-ltext" type="text" name="address" value="{{old('address')}}" placeholder="Your Address" required="">
					<input class="agile-ltext" type="password" name="password" placeholder="Password" required="">
					<div class="wthreelogin-text"> 
						<ul> 
							<li>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i> 
									<span> I agree to the terms of service</span> 
								</label> 
							</li> 
						</ul>
						<div class="clearfix"> </div>
					</div>   
					<input type="submit" value="Sign Up">
				</form>
				<p>Already have an account?  <a href="#"> Login Now!</a></p> 
			</div>	 
		</div>
	</div>
	<!-- //sign up-page -->
	    <script>
        function licenceimage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#licence_image')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function profile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#proflie_image')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
	@endsection