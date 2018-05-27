@extends('layout.layout-user')

@section('title','Register')

@section('content')

<!--==========================
      Contact Section
    ============================-->
    
<br><br><br>
  <section id="contact">
    <div class="container">
      <div class="row wow fadeIn">
        
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

        @if (Session::has('success'))
        <div class="col-lg-12">
          <div class="alert alert-success">
            <i data-notify="icon" class="ion-checkmark"></i>&ensp;
            <span data-notify="message" class="text-center">{{ Session::get('success') }}</span>
          </div>
        </div>
        <br>
        @endif

        <div class="col-lg-5 col-md-8">
          
          <div class="col-lg-4 col-md-4">
            <div class="contact-about">
              <h3>Register</h3>
            </div>
          </div>
        
          <div class="form">
            <div id="sendmessage">Succesfully Registered! Check your email for your temporary password.</div>
            
            <div id="errormessage"></div>

            <form action="/register/add" method="post">
              {{ csrf_field() }}
              
              <div class="container">
              </div>
              
              <!-- Last Name -->
              <div class="form-group">
                <b>Last Name</b>
                <input class="form-control" type="text" name="lname" value="{{ old('lname') }}" required>
              </div>
              
              <!-- First Name -->
              <div class="form-group">
                <b>First Name</b>
                <input class="form-control" type="text" name="fname" value="{{ old('fname') }}" required>
              </div>

              <!-- Middle Name -->
              <div class="form-group">
                <b>Middle Name</b>
                <input class="form-control" type="text" name="mname" value="{{ old('mname') }}" required>
              </div>

              <!-- Company -->
              <div class="form-group">
                <b>Company Name</b>
                <input class="form-control" type="text" name="company" value="{{ old('company') }}" required>
              </div>

              <!-- Email Address -->
              <div class="form-group">
                <b>Email Address</b>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
              </div>

              <!-- Address -->
              <div class="form-group">
                <b>Address</b>
                <input class="form-control" type="text" name="address" value="{{ old('address') }}" required>
              </div>

              <!-- Contact -->
              <div class="form-group">
                <b>Contact Number</b>
                <input class="form-control" type="text" name="contact" value="{{ old('contact') }}" required>
              </div>                

              <div class="text-center">
                <button type="submit" title="Send Message">Register</button>
              </div>
              
            </form>
          </div>
          
        </div>

        <div class="col-md-2"></div>

        <div class="col-lg-5 col-md-8">

          <div class="">
            <div class="contact-about">
              <h3>Login</h3>
            </div>
          </div>

          <div class="form well well-lg">
            <br>
            <div id="sendmessage">Succesfully Registered! Check your email for your temporary password.</div>
            
            <div id="errormessage"></div> 
            
            <form action="/login" method="post">

              {{ csrf_field() }}

              <div class="form-group">
                Email: <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}" data-msg="Please enter email" required="" />
                <div class="validation"></div>
              </div>
                
              <div class="form-group">
                Password: <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" data-msg="Please enter password" required="" />
                <div class="validation"></div>
              </div>
                
              <div><center><a href="/user/request-token">Forgot Password?</a></center></div><br>
              <div class="text-center">
                <button type="submit" title="Send Message">Login</button>
              </div>
              <br>

            </form>
            </div>

            <br><br>

            <div>
              <center>OR<a href="/menu"><h4>Continue as guest</h4></a></center>
            </div> 
          
          </div>
         
        </div>
      </div>
    </section><!-- #contact -->

@endsection