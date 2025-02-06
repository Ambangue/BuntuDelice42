@extends('frontend.layouts.app')
@section('title','Buntudelice | Home ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">
			<div class="container">
				<h2>Delicious food from the <br> <span>Best Restaurants For you.</span></h2>
				<div class="agileits_search">
					<form action="{{route('serach')}}" method="get">
						<input name="qurey" type="text" placeholder="Enter Restaurant Name" required="">
						<input type="submit" value="Search">
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //banner -->
<!-- order -->
	<div class="wthree-order">
		<img src="{{asset('images/i2.jpg')}}" class="m9order-img" alt=""/>
		<div class="container">
			<h3 class="m9ls-title">Top Restaurants</h3>
			<p class="m9lsorder-text">Get your favourite food from top resraurants.</p>
			<div class="order-agileinfo">

  @foreach($restaurants as $restaurant)
  <div class="m9resturants col-md-3 col-sm-3 col-xs-6">
  	<a href="{{route('resturant.detail',$restaurant->id)}}">
    <div class="thumbnail">
      <img src="{{asset('images/restaurant_images/')}}/{{$restaurant->logo}}" alt="..." style="height:200px;">
      <div class="caption">
        <h5>{{$restaurant->name}}</h5>
        <p>
            <b>{{ $restaurant->cuisines->pluck('name')->implode(', ') }}</b>
         <!--   @foreach($restaurant->cuisines as $cuisine)-->
        	<!--{{  $cuisine->name }},-->
        	<!--@endforeach-->
        </p>
        <p>{!! str_repeat('<span><i class="fa fa-star checked"></i></span>', number_format($restaurant->ratings, 1)) !!}{!! str_repeat('<span><i class="fa fa-star"></i></span>', 5 - number_format($restaurant->ratings, 1)) !!}</p>
      </div>
    </div>
    </a>
  </div>
  @endforeach
<style>
    .checked {
  color: orange;
}
</style>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //order -->
	<!-- deals -->
	<div class="m9agile-deals" id="services">
		<div class="container">
			<h3 class="m9ls-title">Special Services</h3>
			<div class="row">
			    
				<div class="col-md-6 col-sm-6 deals-grids">
					<div class="deals-left">
						<img src="{{asset('images/svg/pick-up-truck.png')}}" class="fa" aria-hidden="true" style="width:40px;">
					</div>
					<div class="deals-right">
						<h4>Pickup & Delivery</h4>
						<p>Order from food and alcohol merchants and the drop will pickup your order and drop it off to your door.</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-6 col-sm-6 deals-grids">
					<div class="deals-left">
						<img src="{{asset('images/svg/reservation.png')}}" class="fa" aria-hidden="true">
					</div>
					<div class="deals-right">
						<h4>Table Reservation</h4>
						<p>Make dinner reservations with one of the fine dining restaurants listed.</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-6 col-sm-6 deals-grids">
					<div class="deals-left">
						<img src="{{asset('images/svg/delivery.png')}}" class="fa" aria-hidden="true" style="width:40px;">
					</div>
					<div class="deals-right">
						<h4>Event Catering</h4>
						<p>Having an event and need a caterer? Choose one from the drop down listing.</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-6 col-sm-6 deals-grids">
					<div class="deals-left">
						<img src="{{asset('images/svg/package.png')}}" class="fa" aria-hidden="true" style="width:40px;">
					</div>
					<div class="deals-right">
						<h4>Packages</h4>
						<p>For businesses that need a local professional handler to pickup and deliver a package</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!-- //deals -->
        <div class="m9agile-deals" id="services">
            <div class="container">
                <h3 class="m9ls-title">Merchant Services</h3>
                <div class="dealsrow">
                    
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/fish1.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Seafood & Meat</h4>
                            <p>Order directly from one of our seafood merchants displayed on the website or download the app. </p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/bowl.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Pharmacy</h4>
                            <p>Need your prescription picked up or filled from your preferred pharmacy, choose a merchant, then what’s up text us or send us an email requesting services.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/birthday.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Cakes</h4>
                            <p>Would like to order that birthday cake, sweet treat or pastry, order from one of the drop’s merchants.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/package.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Packages</h4>
                            <p>Have a package to pick up? We pickup and deliver packages from extra small to extra large to your door or the mailboat.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/flower.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Flowers</h4>
                            <p>Is it that special occasion? Surprise your loved one with flowers and let us do the drop for you.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/supermarket.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Grocery</h4>
                            <p>Out of grocery and unable to do the shopping, order here or send us your order by text or email and let us shop and drop your order off to you.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/rinse.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Laundry</h4>
                            <p>Don’t feel like doing the laundry? Or need cloths picked up from the laundry, send your request by text or email so that we may do the drop for you.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="col-md-6 col-sm-6 deals-grids">
                        <div class="deals-left">
                            <img src="{{asset('images/svg/liquor.png')}}" class="fa" aria-hidden="true" style="width:40px;">
                        </div>
                        <div class="deals-right">
                            <h4>Liquor</h4>
                            <p>Had a long day and need a cool off, shop and we drop.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
	<!-- dishes -->
	<div class="m9agile-spldishes">
		<div class="container">
			<h3 class="m9ls-title">Special Foods</h3>
			<div class="spldishes-agileinfo">
				<div class="col-md-3 spldishes-m9left">
					<h5 class="m9ltitle">Buntu Delice Specials</h5>
					<p>Vero vulputate enim non justo posuere placerat Phasellus mauris vulputate enim non justo enim .</p>
				</div>
				<div class="col-md-9 spldishes-grids">
					<!-- Owl-Carousel -->
					<div id="owl-demo" class="owl-carousel text-center agileinfo-gallery-row">
						@foreach($products as $product)
						<a href="{{route('pro.detail', $product->id)}}" class="item g1">
							<img class="lazyOwl" src="{{asset('images/product_images/')}}/{{$product->image}}" title="{{$product->name}}" alt="{{$product->name}}"/ style="height:217px;">
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
@endsection
