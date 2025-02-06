@extends('frontend.layouts.app')
@section('title', 'Thanks For yor Order' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container" style="text-align: center;">
			    <h2>Thank You <br></h2>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Thank You</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu"> 
	<div class="wrapper">
	        <div class="container">
            <div class="row cart-head">
                <div class="container">
                <div class="row">
                    <p></p>
                </div>
                <div class="row">
                    <div style="display: table; margin: auto;">
                        <span class="step step_complete"> <a href="#" class="check-bc">Cart</a> <span class="step_line step_complete"> </span> <span class="step_line backline"> </span> </span>
                        <span class="step step_complete"> <a href="#" class="check-bc">Checkout</a> <span class="step_line step_complete"> </span> <span class="step_line  backline"> </span> </span>
                        <span class="step step_complete"><a href="#" class="check-bc">Thank you</a> <span class="step_line "> </span> <span class="step_line"> </span></span>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <p></p>
                </div>
                </div>
            </div>    
            <div class="row cart-body">
		<div class="container">
				<section>
	<div class="modal-body">
	<div class="row" style="padding:15px;">
	<h3 style="text-align:center;">Thank For The Order!</h3><br>
	ORDER NO: {{$order->order_no}}
	</div>				    
    </div>
    <div class="clearfix"> </div>
				</section>
	</div>
		</div>
	</div>
	</div>
	</div>
	<!-- //menu list -->    
	@endsection 
	