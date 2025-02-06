@extends('frontend.layouts.app')
@section('title',$restaurant->name. ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
			    <h2>{{$restaurant->name}} ({{ number_format($restaurant->ratings, 1)}}) <br></h2>
			    <p style="font-size: 25px;font-family: 'Berkshire Swash', cursive;color:#ffffff;">{{$restaurant->slogan}}</p>
				<h4 style="color:white;">{{ $restaurant->cuisines->pluck('name')->implode(', ') }}</h4>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li> 
			<li class="active">Menu</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="products">	 
		<div class="container">
			<div class="col-md-12 product-m9ls-right"> 
			@foreach($abc as $category)
				<div class="product-top">
					<h4>{{$category->name}}</h4> 
					<div class="clearfix"> </div>
				</div>
				@if($category->products->count() > 0)
				<div class="products-row">
					@foreach($category->products as $pro)
					<div class="col-xs-4 col-sm-4 product-grids" style="margin-bottom:3em;">
						<div class="flip-container flip-container1">
							<div class="flipper agile-products">
								<div class="front" style="height:235px;"> 
									<img src="{{asset('images/product_images/')}}/{{$pro->image}}" class="img-responsive" alt="img" style=" width:100%;height:250px;">
									<div class="agile-product-text">              
										<h5 style="font-size:12px;">{{$pro->name}} </h5>  
									</div> 
								</div>
								<div class="back">
									<h4>{{$pro->name}} </h4>
									<p>{!!$pro->description!!}.</p>
									<h6>{{$pro->price}}<sup>$</sup></h6> 
										<a href="{{route('pro.detail', $pro->id)}}" class="m9ls-cart pm9ls-cart"><i class="fa fa-eye"></i> VIEW ITEM</a>
								</div>
							</div>
						</div> 
					</div>
					@endforeach
					<div class="clearfix"> </div>
				</div>
				@else
				
				<div class="products-row">
				<div class="col-xs-12 col-sm-12 product-grids"><p style="text-align:center;margin-bottom:3em;"> No Product Found!</p></div>
				<div class="clearfix"> </div>
				</div>
				
				@endif
				@endforeach
			</div>
		</div>
	</div>
	<!-- //products -->  
	@endsection 
	