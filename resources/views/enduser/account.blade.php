@extends('layout.layout-account')

@section('title','Account')

@section('content')

<br><br><br><br><br><br>

@if (Session::has('success'))
<div class="row">
  <div class="col-lg-4"></div>
  <div class="col-lg-4">
    <div class="alert alert-success">
      <i data-notify="icon" class="ion-checkmark"></i>&ensp;
      <span data-notify="message" class="text-center">{{ Session::get('success') }}</span>
    </div>
  </div>
  <div class="col-lg-4"></div>
</div>
<br>
@endif

<div class="row">

  <div class="col-md-2"></div>

  <div class="col-md-5">
    <h4>{{$customer->fname}} {{$customer->mname}} {{$customer->lname}}</h4> 
    <p>{{$customer->company}}</p>
    <p>{{$customer->address}} </p>
    <p>{{$customer->contact}}</p>

  </div>

  <div class="col-md-4">

    <div class="container-fluid">
        <h4 class="title">Settings and Actions</h4>
        <hr>
        <button class="btn btn-md btn-success" onclick="window.location.href='/menu'">New Order</button><br><br>
        <button class="btn btn-md btn-style" onclick="window.location.href='account/edit/{{ $customer->id }}'">Edit Your Details</button>&ensp;
        <button class="btn btn-md btn-style change-this" onclick="window.location.href='/account/change-password/{{ $customer->id }}'">Change Your Password</button>&ensp;
        <br><br>
        <button class="btn btn-sm btn-danger disable" onclick="window.location.href='/account/disable-account/{{ $customer->id }}'">Disable your Account</button>

      </div>
  </div>

  <div class="col-md-1"></div>

</div>

  <br>
</div>

<div class="row">
<div class="col-md-2"></div>

  <div class="col-md-8">
    <table>
      <th colspan="5">Orders</th>
      <tr>
        <td>Order Date</td>
        <td>Order ID</td>
        <td>Total Price</td>
        <td>Status</td>
        <td>Action</td>
      </tr>

@if ($orders->isEmpty())
  <tr>
    <td colspan="5"><b><center>No orders to show.</center></b></td>
  </tr>

@else

  @foreach($orders as $order)
      <tr>
          <td>{{$order->trans_date}}</td>
          <td>{{$order->order_id}}</td>
          <td>{{$order->total_cost}}</td>
          <td>{{$order->status}}</td>
          <td>
            @if ($order->status != 'Reserved')
            <button class="btn btn-sm btn-danger" disabled><i class="ion-close-circled"></i>&ensp;Cancel</button>
            @else
            <button class="btn btn-sm btn-danger" onclick="window.location.href='/cancel-reservation/{{ $order->id }}'"><i class="ion-close-circled"></i>&ensp;Cancel</button>
            @endif
          </td>
        </tr>
  @endforeach

@endif
      

    </table>
  </div>


</div>
  <br>
</div>



@endsection