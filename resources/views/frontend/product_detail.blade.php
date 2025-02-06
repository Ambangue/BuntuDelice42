@extends('frontend.layouts.app')
@section('title', $proDetail->name . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
			    <h2>{{$restaurant->name}} <br></h2>
			    <p style="font-size: 25px;font-family: 'Berkshire Swash', cursive;color:#ffffff;">{{$proDetail->name}}</p>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="{{route('resturant.detail',$restaurant->id)}}"> {{$restaurant->name}}</a></li>
			<li class="active">{{$proDetail->name}}</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu">  
		<div class="container">
			<div class="m9resturants">
				<section>
				    @if(Session::has('message'))
                    <div class="alert alert-success text-center" role="alert">
                       <b> {{Session::get('message')}}</b>
                    </div>
                   @endif
					<div class="modal-body">
						<div class="col-md-5 modal_body_left">
							<img src="{{asset('images/product_images')}}/{{$proDetail->image}}" alt=" " class="img-responsive" style="width:100%;max-height:400px;">
						</div>
						<div class="col-md-7 modal_body_right single-top-right"> 
							<h3 class="item_name" style="text-align: left;">{{$proDetail->name}}</h3>
							<div class="single-price">
								<ul>
									<li>${{$proDetail->price}}</li>  
									<li><del>${{$proDetail->discount_price}}</del></li> 
								</ul>	
							</div>
							
							<p class="single-price-text" style="text-align: left;">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.</p>
							   
							<form action="{{route('cart')}}" method="post" class="form-horizontal">
							    <h3 class="item_name">Qty</h3>
							    <div class="row">
							<div class="col-sm-10">
								<input type="number" name="qty" value="1" min="1" max="10"  style="width:8%;"/>
								</div></div>
							       <h3 class="item_name">Instructions</h3>
							 <div class="row">
							<div class="col-sm-10">
							 <textarea name="txtarea1" id="txtarea1"  rows="8" class="form-control1"></textarea>
							</div>
							    </div>
							<br>
							    @csrf
								<input type="hidden" name="restaurant_id" value="{{$restaurant->id}}" />
								<input type="hidden" name="user_id" value="@if(Auth::check()) {{auth()->user()->id}} @endif" /> 
								<input type="hidden" name="product_id" value="{{$proDetail->id}}" /> 
								<input type="hidden" name="product_name" value="{{$proDetail->name}}" /> 
								<input type="hidden" name="price" value="{{$proDetail->price}}" /> 
								<button type="submit" class="m9ls-cart" style="margin-top:0;"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
							</form>
						</div> 
						<div class="clearfix"> </div>
					</div>
				</section>
			</div>
			
			<!-- dishes -->
	<div class="m9agile-spldishes">
		<div class="container">
			<h3 class="m9ls-title">Special Foods</h3>
			<div class="spldishes-agileinfo">
				<div class="col-md-3 spldishes-m9left">
					<h5 class="m9ltitle">Related Products</h5>
					<p>Vero vulputate enim non justo posuere placerat Phasellus mauris vulputate enim non justo enim .</p>
				</div> 
				<div class="col-md-9 spldishes-grids">
					<!-- Owl-Carousel -->
					<div id="owl-demo" class="owl-carousel text-center agileinfo-gallery-row">
						@foreach($products as $product)
						<a href="{{route('pro.detail', $product->id)}}" class="item g1">
							<img class="lazyOwl" src="{{asset('images/product_images/')}}/{{$product->image}}" title="{{$product->name}}" alt="{{$product->name}}" style="height:190px;"/>
							<div class="agile-dish-caption">
								<h4>{{$product->name}}</h4>
								<span>Neque porro quisquam est qui dolorem </span>
							</div>
						</a>
						@endforeach
					</div> 
				</div>  
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //dishes -->
		</div>
	</div>
	<!-- //menu list -->    
	@endsection 
	