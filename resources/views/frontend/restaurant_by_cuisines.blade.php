@extends('frontend.layouts.app')
@section('title', 'Restaurants By Cuisines | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container">
			    <h2>Restaurants <br></h2>
			    <p style="font-size: 25px;font-family: 'Berkshire Swash', cursive;color:#ffffff;">By Cuisines</p>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#">Restaurants</a></li>
			<li class="active"> Restaurants By Cuisines</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu">  
		<div class="container-fluid">
			<div class="m9resturants">
					<div class="wthree-order">
		<img src="{{asset('images/i2.jpg')}}" class="m9order-img" alt=""/>
		<div class="container">
			<h3 class="m9ls-title">Restaurants By Cuisines</h3>
			<p class="m9lsorder-text">Get your favourite food from top resraurants.</p>
			<div class="order-agileinfo">
  @if($cuisines->restaurants->count()>0)
  @foreach($cuisines->restaurants as $restaurant)
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
        <p>{!! str_repeat('<span><i class="fa fa-star checked"></i></span>', number_format(number_format($restaurant->ratings->avg('rating'), 1))) !!}{!! str_repeat('<span><i class="fa fa-star"></i></span>', 5 - number_format(number_format($restaurant->ratings->avg('rating'), 1))) !!}</p>
      </div>
    </div>
    </a>
  </div>
  @endforeach
  @else
  <p class="m9lsorder-text" style="text-align:center;color:red;"><b>No Restaurant Found!</b></p>
  @endif
<style>
    .checked {
  color: orange;
}
</style>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
			</div>
	<!-- //dishes -->
		</div>
	</div>
	<!-- //menu list -->    
	@endsection 
	