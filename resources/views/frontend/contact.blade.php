@extends('frontend.layouts.app')
@section('title', 'Contact Us' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')
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
			<li class="active">Contact Us</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<!-- contact -->
	<div id="contact" class="contact cd-section">
		<div class="container">
			<h3 class="m9ls-title">Contact us</h3>
			<p class="m9lsorder-text">Please send your message below. We will get back to you at the earliest!</p>
			<div class="contact-row agileits-m9layouts">
				<div class="col-xs-6 col-sm-6 contact-m9lsleft">
					<div class="contact-grid agileits">
						<h4>DROP US A LINE </h4>
						<form action="{{route('contact')}}" method="post">
                            @csrf
							<input type="text" name="name" placeholder="Name" required="">
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
                            @endif
							<input type="email" name="email" placeholder="Email" required="">
							<input type="text" name="phone" placeholder="Phone Number" required="">
							<textarea name="message" placeholder="Message..." required=""></textarea>
							<input type="submit" value="Submit" >
						</form>
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 contact-m9lsright">
					<h6 style="font-size:21px;"><span>Any questions </span>regarding our website and other information? Please complete the following form, and our support team will get in touch with you.</h6>
					<div class="address-row">
						<div class="col-xs-2 address-left">
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
						</div>
						<div class="col-xs-10 address-right">
							<h5>Visit Us</h5>
							<p>Broome St, Canada, NY 10002, New York </p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="address-row m9-agileits">
						<div class="col-xs-2 address-left">
							<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
						</div>
						<div class="col-xs-10 address-right">
							<h5>Mail Us</h5>
							<p><a href="mailto:care@thedrop247.com"> care@thedrop247.com</a></p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="address-row">
						<div class="col-xs-2 address-left">
							<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
						</div>
						<div class="col-xs-10 address-right">
							<h5>Call Us</h5>
							<p>+01 222 333 4444</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
		<!-- map -->
		<div class="map agileits">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.948805392833!2d-73.99619098458929!3d40.71914347933105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a27e2f24131%3A0x64ffc98d24069f02!2sCANADA!5e0!3m2!1sen!2sin!4v1479793484055"></iframe>
		</div>
		<!-- //map -->
	</div>
	<!-- //contact -->
	<!-- subscribe -->
	<div class="subscribe agileits-m9layouts">
		<div class="container">
			<div class="col-md-6 social-icons m9-agile-icons">
				<h4>Keep in touch</h4>
				<ul>
					<li><a href="https://www.facebook.com/Thedrop247/" target="_blank" class="fa fa-facebook icon facebook"> </a></li>
					<li><a href="https://twitter.com/thedrop247" target="_blank" class="fa fa-twitter icon twitter"> </a></li>
					<li><a href="https://www.instagram.com/thedrop24_7/" target="_blank" class="fa fa-instagram icon instagram"> </a></li>
				</ul>
			</div>
			<div class="col-md-6 subscribe-right social-icons m9-agile-icons">
                <h4>Our app</h4>
                <ul class="apps">
                    <li><h4>Download Our app : </h4> </li>
                    <li><a href="#" class="fa fa-apple"></a></li>
                    <li><a href="#" class="fa fa-windows"></a></li>
                    <li><a href="#" class="fa fa-android"></a></li>
                </ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- //subscribe -->
@endsection
