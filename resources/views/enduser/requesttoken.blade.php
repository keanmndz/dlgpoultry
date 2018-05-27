@extends('layout.layout-user')

@section('title', 'Request for Password Reset')

@section('content')

<!--==========================
      Contact Section
    ============================-->
    
<br><br><br>
  <section id="contact">
    <div class="container">
      <div class="row wow fadeIn">

        <div class="col-lg-4 col-lg-offset-4">

          <div class="">
            <div class="contact-about">

            @if (Session::has('wrong'))
            <div class="row">
              <div class="col-lg-12 alert alert-danger">
                <i data-notify="icon" class="ion-close"></i>&ensp;
                <span data-notify="message" class="text-center">{{ Session::get('wrong') }}</span>
              </div>
            </div>
            <br>
            @endif

              <h3>Request</h3>
            </div>
            <hr>
            <p class="text-center">Enter the email you use upon login. You will receive an email for the next steps if your email is valid. You may also contact the Administrator for additional help.</p>          
          </div>

          <div class="form well well-lg">
            <br>
          <div class="col-lg-12">

            <!--  Error handle -->
            @if($errors->any())
              <div class="alert alert-danger text-center">
                @foreach($errors->all() as $error)
                  {{ $error }}
                  <br>
                @endforeach
              </div>
            @endif
          </div>
            
            <form action="/user/send-fpw" method="post">

              {{ csrf_field() }}

              <div class="form-group">
                Email: <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}" required="" />
                <div class="validation"></div>
              </div>
                
              
              <div class="text-center">
                <button type="submit">Request</button>
              </div>
              <br>

            </form>

            </div>

          </div>
         
        </div>
      </div>
    </section><!-- #contact -->

@endsection