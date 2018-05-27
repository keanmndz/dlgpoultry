@extends('layout.layout-account')

@section('title','Account')

@section('content')

<br><br><br><br>

&ensp;&ensp;&ensp;<button type="button" class="btn btn-md btn-simple" onclick="window.location.href='/account'">Back to Your Account</button>

<div class="row">

  <div class="col-lg-1"></div>

  <div class="col-lg-10">

    <!--  Error handle -->
    @if($errors->any())
    <div class="alert alert-warning">
        <ul>
            @foreach($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif

  </div>

  <div class="col-lg-1"></div>

</div>

<div class="row">
  <div class="col-lg-1"></div>

  <div class="col-lg-10">
    <form action="/account/edit/{{ $customers->id }}/insert" method="post">

      <center><legend><h3>Update Your Details</h3></legend></center>
        
        {{ csrf_field() }}

      <!-- Last Name -->
      <div class="form-group">
        Last Name: <input class="form-control" type="text" name="lname" value="{{ $customers->lname }}" required autofocus>
      </div>

      <!-- First Name -->
      <div class="form-group">
        First Name: <input class="form-control" type="text" name="fname" value="{{ $customers->fname }}" required>
      </div>

      <!-- Middle Name -->
      <div class="form-group">
        Middle Name: <input class="form-control" type="text" name="mname" value="{{ $customers->mname }}" required>
      </div>

      <!-- Company -->
      <div class="form-group">
        Company Name: <input class="form-control" type="text" name="company" value="{{ $customers->company }}" required>
      </div>

      <!-- Address -->
      <div class="form-group">
        Address: <input class="form-control" type="text" name="address" value="{{ $customers->address }}" required>
      </div>

      <!-- Contact -->
      <div class="form-group">
        Contact Number: <input class="form-control" type="text" name="contact" value="{{ $customers->contact }}" required>
      </div>

        <!-- Button --> 
        <center><div class="form-group">
          <button type="submit" class="btn btn-md btn-style">Update Details</button>
        </div></center>

      </form>

  </div>

  <div class="col-lg-1"></div>

</div>
  <br>
</div>

@endsection