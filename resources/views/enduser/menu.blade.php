@extends('layout.layout-order')

@section('title','Register')

@section('content')

<br><br><br><br><br><br>

<h4 class="text-center">Note: you may reserve items with a minimum quantity of 30. Items that are not shown below are unavailable for reservation.</h4>

<div class="row">
	
	<div class="col-lg-1"></div>

	<div class="container col-lg-5">
		<table>
			<tr>
			<th colspan="2"><center><h4>Products</h4></center></th>
			</tr>

			@foreach($prods as $products)
				@if($products->id % 2 != 0)
				<tr>
					<td>
						<div class="row">
							<div class="col-lg-6">
								<h5>{{$products->name}}</h5>
								<p>Php {{$products->wholesale_price}}</p>
							</div>
						</div>
						<div class="text-center">
							<form method="POST" action="/menu">
								<div class="form-group col-lg-">
									<input class="form-control" placeholder="Quantity" type="number" name="quantity" autocomplete="off" min="30" max="{{$products->stocks}}" required>
								</div>
		              			<input type="hidden" name="product_id" value="{{$products->id}}">
		              			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		              			<button type="submit" class="btn btn-fefault add-to-cart">
		                 			<i class="fa fa-shopping-cart"></i>
		                    		Add to cart
		               			</button>
		             		</form>
		             	</div>
					</td>
				@endif
					
				@if($products->id %2 == 0)
					<td>
						<div class="row">
							<div class="col-lg-6">
								<h5>{{$products->name}}</h5>
								<p>Php {{$products->wholesale_price}}</p>
							</div>
						</div>
						<div class="text-center">
							<form method="POST" action="/menu">
								<div class="form-group">
									<input class="form-control" placeholder="Quantity" type="number" name="quantity" autocomplete="off" size="2" min="30" max="{{$products->stocks}}" required>
								</div>
		              			<input type="hidden" name="product_id" value="{{$products->id}}">
		              			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		              			<button type="submit" class="btn btn-fefault add-to-cart">
		                 			<i class="fa fa-shopping-cart"></i>
		                    		Add to cart
		               			</button>
		             		</form>
		             	</div>
					</td>
				</tr>
				@endif
			@endforeach
		</table>
	</div>

	<div class="col-lg-5">
		<div class="">
			<table>
				<tr>
					<th colspan="5"><center><h4>Cart</h4></center></th>
				</tr>
				<tr>
					<td>Product</td>
					<td>Price</td>
					<td>Qty</td>
					<td>Subtotal</td>
					<td></td>
				</tr>

				@if($cart->isEmpty())
					
					<tr>
						<td colspan="5"><center><b>Cart empty.</b></center></td>
					</tr>

				@else

				@foreach($cart as $item)
                    <tr>
                        <td class="cart_description">
                            <p>{{$item->name}}</p>
                        </td>
                        <td class="cart_price">
                            <p>P {{$item->price}}.00</p>
                        </td>
                        <td class="cart_quantity">
                            <p>{{$item->qty}}</p>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price" id="subtotal">P {{$item->subtotal}}.00</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href='{{url("menu/remove?product_id=$item->id")}}'><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach

                @endif
			</table>

			<br>

			<center>
				<form method="POST" action="/checkout">
					<input type="hidden" name="product_id" value="{{$products->id}}">
              		<input type="hidden" name="_token" value="{{ csrf_token() }}">
              		<button type="submit" class="btn btn-fefault add-to-cart">
                    	Checkout
               		</button>
             	</form>
            </center>
        </div>
    </div>

    <div class="col-lg-1"></div>
</div>

<br>

@endsection