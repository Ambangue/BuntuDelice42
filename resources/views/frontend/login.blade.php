@extends('frontend.layouts.app')
@section('title', 'Login | Buntu Delice ')
@section('keywords','Quote')
@section('content') 
		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
				<h2>Delicious food from the <br> <span>Best Chefs For you.</span></h2> 
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="#"><i class="fa fa-home"></i> Home</a></li> 
			<li class="active">Login</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<!-- login-page -->
	<style>
form {
  background-color: #fff;
  padding: 30px;
  color: #000;
}

form .agile-ltext::-webkit-input-placeholder { 
  color: #4CAF50;
}

form .agile-ltext::-moz-placeholder {
  color: #4CAF50;
}
form .agile-ltext:-ms-input-placeholder {
  color: #4CAF50;
}
form .agile-ltext:placeholder {
  color: #4CAF50;
}
</style>
	<div class="login-page about">
		<img class="login-m9img" src="images/img3.jpg" alt="">
		<div class="container"> 
			<h3 class="m9ls-title m9ls-title1">Login to your account</h3>
			@if(Session::has('message'))
                    <div class="alert alert-success text-center" role="alert">
                       <b> {{Session::get('message')}}</b>
                    </div>
            @endif
			<div class="login-agileinfo"> 
				<form method="post" action="{{ url('login') }}">
                @csrf 
					<input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address"
                           class="agile-ltext">
                    @if($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
					<input class="agile-ltext" type="password" name="password" placeholder="Enter your password">
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
							<li><a href="{{route('user.forgot')}}">Forgot password?</a> </li>
						</ul>
						<div class="clearfix"> </div>
					</div>   
					<input type="submit" value="LOGIN">
				</form>
				<p>Don't have an Account? <a href="{{route('user.signup')}}"> Sign Up Now!</a></p> 
			</div>	 
		</div>
	</div>
	<!-- //login-page -->  
	@endsection
