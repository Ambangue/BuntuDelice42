@extends('frontend.layouts.app')
@section('title', 'Forgot Password | Buntu Delice ')
@section('keywords','Quote')
@section('content') 
		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
				<h2>Delicious food from the <br> <span>Best Restaurant For you.</span></h2> 
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="#"><i class="fa fa-home"></i> Home</a></li> 
			<li class="active">Forgot Password</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<!-- login-page -->
	<div class="login-page about">
		<img class="login-m9img" src="images/img3.jpg" alt="">
		<div class="container"> 
			<h3 class="m9ls-title m9ls-title1">Forgot password</h3> 
			@if(Session::has('message'))
                    <div class="alert alert-success text-center" role="alert">
                       <b> {{Session::get('message')}}</b>
                    </div>
            @endif
			<div class="login-agileinfo"> 
				<form method="post" action="{{ route('forgot') }}">
                @csrf 
					<input class="agile-ltext" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                           class="form-control {{ $errors->has('email') ? ' is-invalid' : ''}}">
                    @if($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <input class="agile-ltext" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone"
                           class="form-control {{ $errors->has('phone') ? ' is-invalid' : ''}}">
                    @if($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
					<input class="agile-ltext" type="password" name="password" placeholder="Password">
					@if($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
					<div class="wthreelogin-text"> 
						<ul> 
							<li>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i> 
									<span> Remember me ?</span> 
								</label> 
							</li>
							<li><a href="#">Forgot password?</a> </li>
						</ul>
						<div class="clearfix"> </div>
					</div>   
					<input type="submit" value="CHANGE PASSWORD">
				</form>
				<p>Already have an Account? <a href="{{route('user.login')}}"> Sign In!</a></p> 
			</div>	 
		</div>
	</div>
	<!-- //login-page -->  
	@endsection
