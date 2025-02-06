@extends('frontend.layouts.app')
@section('title', 'Checkout' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container" style="text-align: center;">
			    <h2>Your Results <br></h2>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#">Qurey</a></li>
			<li class="active">{{$qurey}}</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu">
	<div class="wrapper">
	<div class="container">
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
        </p>
        <p>
            {!! str_repeat('<span><i class="fa fa-star checked"></i></span>', number_format($restaurant->ratings)) !!}{!! str_repeat('<span><i class="fa fa-star"></i></span>', 5 - number_format($restaurant->ratings)) !!}
        </p>
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
	</div>
	<!-- //menu list -->    
	@endsection 
	