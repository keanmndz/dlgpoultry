@extends('layout.layout-order')

@section('title','Register')

@section('content')

<br><br><br><br><br>

<div class="row">
	
	<div class="col-md-1"></div>

	<div class="col-md-4">
		<h3>{{$lname}}, {{$fname}} {{$mname}}</h3>
		<p>{{$email}}<br>{{$company}}<br>{{$address}}<br>{{$contact}}</p>

		<br>

		<table>
            <tr>
              <th colspan="4"><center><h4>Order</h4></center></th>
            </tr>

            <tr>
              <td><a href="">Product</a></td>
              <td><a href="">Price</a></td>
              <td><a href="">Qty</a></td>
              <td><a href="">Subtotal</a></td>
            </tr>

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
                  <p class="cart_total_price">P {{$item->subtotal}}.00</p>
                </td>
              </tr>
            @endforeach

            <tr>
              <td colspan="3">TOTAL </td>
                <td><p>P{{Cart::subtotal()}}</p></td>
            </tr>
   
          </table>
	</div>

	<div class="col-md-1"></div>

	<div class="alert col-md-4">
		<h5>Reminder:</h5>
		<p><i>Orders should be picked up 24 hours after its reservation. Otherwise, the reservation will be cancelled. </i></p>

		<br>

		<p>Please check your details and click reserve.</p>

		<br>
  
    {{ csrf_field() }}

    <form action="/reserve" method="post">
      <input type="hidden" class="form-control" id="email" name="email" value="{{ $email }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="submit" class="btn btn-style btn-md" value="Reserve Order">
    </form>

	</div>

</div>

<br>

@endsection