@extends('frontend.layouts.app')
@section('title', 'Checkout' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">
			<div class="container" style="text-align: center;">
			    <h2>Checkout <br></h2>
			</div>
		</div>
	</div>
	<!-- //banner -->
	<!-- breadcrumb -->
	<div class="container">
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Checkout</li>
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
                        <span class="step step_complete"> <a href="#" class="check-bc">Checkout</a> <span class="step_line "> </span> <span class="step_line step_complete"> </span> </span>
                        <span class="step_thankyou check-bc step_complete">Thank you</span>
                    </div>
                </div>
                <div class="row" style="padding:5px;">
                    <p></p>
                </div>
                </div>
            </div>
            <div class="row cart-body">
                <form class="form-horizontal" method="post" action="{!! URL::to('paypal') !!}">
                    @csrf
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                    <!--REVIEW ORDER-->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Review Order <div class="pull-right"><small><a class="afix-1" href="#">Edit Cart</a></small></div>
                        </div>
                        <div class="panel-body">
                            @foreach($checkoutData as $checkout)
                            <div class="form-group">
                                <div class="col-sm-3 col-xs-3">
                                    <img class="img-responsive" src="{{asset('images/product_images')}}/{{$checkout->image}}" />
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-xs-12">{{$checkout->name}}</div>
                                    <input type="hidden" name="item" value="{{$checkout->name}}">
                                    <div class="col-xs-12"><small>Quantity:<span>{{$checkout->qty}}</span></small></div>
                                    
                                </div>
                                <div class="col-sm-3 col-xs-3 text-right">
                                    <p><span>$</span><b>{{$checkout->price}}</b></p>
                                </div>
                            </div>
                            <div class="form-group"><hr /></div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <strong>Subtotal</strong>
                                    <div class="pull-right"><span>$</span><span><strong>{{number_format($total,2)}}</strong></span></div>
                                </div>
                                @php
                                  $tax=  $charges->tax/100*$total;
                                @endphp
                                @php
                                  $service_fee=($charges->delivery_fee+$tax+$total)/100*$charges->service_fee;
                                @endphp
                                <div class="col-xs-12">
                                    <small>Delivery Fee</small>
                                    <div class="pull-right"><span>${{number_format($charges->delivery_fee,2)}}</span></div>
                                </div>
                                <div class="col-xs-12">
                                    <small>Service Fee</small>
                                    <div class="pull-right"><span>${{number_format($service_fee,2)}}</span></div>
                                </div>
                                <div class="col-xs-12">
                                    <small>Tax</small>
                                    <div class="pull-right"><span>${{number_format($tax,2)}}</span></div>
                                </div>
                            </div>
                                
                            <div class="form-group"><hr /></div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    
                                    <strong>Order Total</strong>
                                    <div class="pull-right"><span>$</span><span><strong id="ttotal">{{number_format($total + $charges->delivery_fee + $tax + $service_fee,2)}}</strong></span></div>
                                </div>
                            </div>
                            <div class="form-group"><hr /></div>
                            <div class="form-group">
                                <div class="col-xs-2"></div>
                                <div class="col-xs-8">
                                    <button type="submit" id="order" class="btn btn-success btn-block">Place Order</button>
                                </div>
                                <div class="col-xs-2"></div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="qty" value="1">
                    <input type="hidden" id="restaurant" value="{{$resturant->restaurant_id}}">
                    <input type="hidden" name="sub_total" value="{{$total}}">
                    <input type="hidden" name="tax" value="{{$charges->tax}}">
                    <input type="hidden" name="delivery_charges" value="{{$charges->delivery_fee }}">
                    <input type="hidden" id="sub_total" value="{{number_format($total + $charges->delivery_fee + $tax + $service_fee,2)}}">
                    <input type="hidden" id="total" name="amount" value="{{number_format($total + $charges->delivery_fee + $tax + $service_fee,2)}}">
                    <!--REVIEW ORDER END-->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--SHIPPING METHOD-->
                    <div class="panel panel-info">
                        <div class="panel-heading">Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>Shipping Address</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>First Name:</strong>
                                    <input type="text" name="first_name" class="form-control" value="@if(Auth::check()) {{auth()->user()->name}} @else  @endif" disabled/>
                                </div>
                                <div class="span1"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Address:</strong></div>
                                <div class="col-md-12">
                                    <input type="text" id="searchMapInput" name="delivery_address" class="form-control" value="" placeholder="Enter a address" required=""/>
                                    <input type="hidden" id="latitude" name="d_lat" value="30.0686741">
                                    <input type="hidden" id="longitude" name="d_lng" value="60.3316196">
                                    @if($errors->has('delivery_address'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('delivery_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Phone Number:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" value="@if(Auth::check()) {{auth()->user()->phone}} @else  @endif" disabled/></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12"><strong>Email Address:</strong></div>
                                <div class="col-md-12"><input type="text" class="form-control" value="@if(Auth::check()) {{auth()->user()->email}} @else  @endif" disabled/></div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                </div>
                </form>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--SHIPPING METHOD-->
                    <div class="panel panel-info">
                        <div class="panel-heading">Driver Tip</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>Driver Tip & Vouchers</h4>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-6 col-xs-12">
                                    <strong>Tip:</strong>
                                    <div class="input-group">
                                       <input type="number" min="1" max="100" id="tip"  name="driver_tip" class="form-control">
                                       <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="myFunction()" type="button">Add</button>
                                       </span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <strong>Apply Vouchers:</strong>
                                    <form id="voucherForm">
                                    <div class="input-group">
                                       <input type="text" name="voucher" id="voucher" class="form-control">
                                       <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Apply</button>
                                       </span>
                                    </div>
                                    </form>
                                </div>
                                <div class="span1"></div>
                            </div>
                        </div>
                    </div>
                    <!--SHIPPING METHOD END-->
                </div>

                


            </div>
            <div class="row cart-footer">
              <div id="map"></div>
            </div>
    </div>
    </div>
	</div>
	@endsection
	@section('script')
<script>
function myFunction() {
  var total= document.getElementById("sub_total").value;
  var tip= document.getElementById("tip").value;
  document.getElementById("ttotal").innerHTML = Number(total)+Number(tip) ;
  document.getElementById("total").value = Number(total)+Number(tip) ;
}
</script>
<script>
        $('#voucherForm').on('submit',function(event){
            event.preventDefault();
            var value4='';
            var total= document.getElementById("sub_total").value;
            voucher = $('#voucher').val();
            restaurant = $('#restaurant').val();

            $.ajax({
                url: "{{url('/voucher/')}}",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    voucher:voucher,
                    restaurant:restaurant,
                },
                success:function(response){
                
                if(response.data != null){
                    
                    var result=response.data.discount / 100 * total ;
                    console.log(result);
                document.getElementById("ttotal").innerHTML =total-result;
                document.getElementById("total").value =total-result;
                }
                
                
                },
            });
        });
    </script>
	<script>
function initMap() {
    var lati = document.getElementById('latitude').value;
    var long = document.getElementById('longitude').value;

    var myLatlng = new google.maps.LatLng(Number(lati),Number(long));
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: Number(lati), lng: Number(long)},
      zoom: 13
    });
    
    //
    var input = document.getElementById('searchMapInput');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
  
    var infowindow = new google.maps.InfoWindow();
     var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          draggable:true
         
        });

    autocomplete.addListener('place_changed', function() {
        //infowindow.close();
        marker.setVisible(true);
        var place = autocomplete.getPlace();
    
        /* If the place has a geometry, then present it on a map. */
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      console.log('Place'+place.name);
        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
        //check rerstaurant address comes within area selected
        fun_check_restaurant(place.geometry.location.lat(), place.geometry.location.lng());

        /* Location details */
    });
        // draggabled address /* Start

        google.maps.event.addListener(marker, 'dragend', 
        function(marker){
        var latLng = marker.latLng; 
        currentLatitude = latLng.lat();
        currentLongitude = latLng.lng();

        
  console.log('dragend'+currentLatitude);

            geocoder.geocode({'latLng': latLng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                    document.getElementById('searchMapInput').value = results[0].formatted_address;
                    document.getElementById('latitude').value = currentLatitude;
                    document.getElementById('longitude').value = currentLongitude;
                    infowindow.setContent('<div>' + results[0].formatted_address + '<br>');
                    infowindow.open(map, marker);
                    }
                }
            });
        }); 

        // draggabled address /* End

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABjZqWBy5HsnxCk7cdcwzdu0C0g82GNFk&libraries=places&callback=initMap" async defer></script>
	@endsection