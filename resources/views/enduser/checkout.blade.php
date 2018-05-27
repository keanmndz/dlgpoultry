@extends('layout.layout-order')

@section('title','Register')

@section('content')

<br><br><br><br><br><br>

<h4 class="text-center">Note: reservations should be picked-up 24 hours after its approval</h4>

<section id="contact">
  <div class="container">
    <div class="row wow fadeInUp">
      
      <div class="col-lg-5 col-md-8">
        
        <div class="col-lg-4 col-md-4">
          <div class="contact-about">
            <h3>Details</h3>
          </div>
        </div>

        {{ csrf_field() }}

        <div class="form">
          <form action="/confirm" method="post">
            @if ($customer == null)
            <div class="form-group">
              <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" data-rule="minlen:2" value="{{ old('lname') }}" data-msg="Please enter at least 2 chars of subject" />
              <div class="validation"></div>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" data-rule="minlen:2" value="{{ old('fname') }}" data-msg="Please enter at least 2 chars of subject" />
              <div class="validation"></div>
            </div>

             <div class="form-group">
              <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name" data-rule="minlen:2" value="{{ old('mname') }}" data-msg="Please enter at least 2 chars of subject" />
              <div class="validation"></div>
            </div>

            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" data-rule="minlen:4" value="{{ old('email') }}" data-msg="Please enter a valid email address" />
              <div class="validation"></div>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="company" id="company" placeholder="Company" data-rule="minlen:4" value="{{ old('company') }}" data-msg="Please enter at least 8 chars of subject" />
              <div class="validation"></div>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="address" id="address" placeholder="Address" data-rule="minlen:4" value="{{ old('address') }}" data-msg="Please enter at least 8 chars of subject" />
              <div class="validation"></div>
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="contactnum" id="contactnum" placeholder="+639*********" data-rule="minlen:11" value="{{ old('contactnum') }}" data-msg="Please enter at least 11 chars of subject" />
              <div class="validation"></div>
            </div>
            @else
            <div class="form-group">
              <input type="text" class="form-control" name="lname" id="lname" value="{{ $customer->lname }}">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="fname" id="fname" value="{{ $customer->fname }}">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="mname" id="mname" value="{{ $customer->mname }}">
            </div>

            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email" value="{{ $customer->email }}">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="company" id="company" value="{{ $customer->company }}">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="address" id="address" value="{{ $customer->address }}">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="contactnum" id="contactnum" value="{{ $customer->contact }}">
            </div>
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-fefault add-to-cart">
                Checkout
              </button>

          </form>

        </div>

      </div>

      <div class="col-md-1"></div>

      <div class="col-lg-6">
        <div class="">
          <table>
            <tr>
              <th colspan="4"><center><h4>Order Summary</h4></center></th>
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
      </div>

    </div>
  </section>


<br>

@endsection