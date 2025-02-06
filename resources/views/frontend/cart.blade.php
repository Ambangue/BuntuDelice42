@extends('frontend.layouts.app')
@section('title', 'Cart' . ' | Buntu Delice ')
@section('keywords','Quote')
@section('content')

		<!-- banner-text -->
		<div class="banner-text">	
			<div class="container" style="text-align: center;">
			    <h2>Your Cart <br></h2>
			</div>
		</div>
	</div>
	<!-- //banner -->    
	<!-- breadcrumb -->  
	<div class="container">	
		<ol class="breadcrumb m9l-crumbs">
			<li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Your Cart</li>
		</ol>
	</div>
	<!-- //breadcrumb -->
	<div class="wthree-menu"> 
	<div class="wrapper">
	        <div class="container">
            <div class="row cart-head">
                <div class="container">
                <div class="row">
                    <p>
                        @if(session()->has('alert'))
            <div class="alert alert-{{ session()->get('alert.type') }}" style="text-align:center;font-weight:bold;">
                {{ session()->get('alert.message') }}
            </div>
            @endif
                    </p>
                </div>
                <div class="row">
                    <div style="display: table; margin: auto;">
                        <span class="step step_complete"> <a href="#" class="check-bc">Cart</a> <span class="step_line step_complete"> </span> <span class="step_line backline"> </span> </span>
                        <span class="step_thankyou step_complete"> Checkout</span>
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
					    
					    
	    <table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
						
					</thead>
					<tbody>
					    @if($cartData->count()>0)
						@foreach($cartData as $data)
						<tr>
						    
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-2 hidden-xs"><img src="{{asset('images/product_images')}}/{{$data->image}}" alt="..." class="img-responsive"/></div>
									<div class="col-sm-10">
										<h4 class="nomargin">{{$data->name}}</h4>
										<p>{!!Str::limit($data->description, 70)!!}</p>
									</div>
								</div>
							</td>
							<td data-th="Price">${{$data->price}}</td>
							<form action="{{route('cart.update',$data->id)}}" method="post">
					        @csrf
					        @method('PUT')
							<td data-th="Quantity">
								<input type="number" class="form-control text-center" name="qty" value="{{$data->qty}}" max="10" min="1" style="width: 100%;">
							</td>
							<td data-th="Subtotal" class="text-center">${{number_format($data->price * $data->qty)}}.00</td>
							<td class="actions" data-th="">
								<button class="btn btn-info btn-sm" type="submit"><i class="fa fa-refresh"></i></button>
								<a  href="{{route('cart.item',$data->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>								
							</td>
							
						</form>
						</tr>
						@endforeach
						@else
                         <tr>
						<td colspan="5"><h3 style="text-align:center;"><br>Your Cart Is Empty!</br></h3></td>
						</tr>
						@endif
					</tbody>
					<tfoot>
						<tr>
							<td><a href="{{url('/')}}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-center"><strong>Total {{$total}}.00</strong></td>
							<td>
							    @if($check!=null)
							    @if($check->min_order <= $total)
							    <a href="{{route('checkout.detail')}}" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a>
							    @else
							    <a href="#" class="btn btn-success btn-block">Minimum Order should be ${{$check->min_order}}</a>
							    @endif
							    @endif
							    
							</td>
						</tr>
					</tfoot>
				</table>
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
	