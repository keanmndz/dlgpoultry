@extends('layout.layout-account')

@section('title', 'Password Reset')

@section('content')

<!--==========================
      Contact Section
    ============================-->
    
<br><br><br>
  <section id="contact">
    <div class="container">
      <div class="row wow fadeIn">
  
        <div class="col-lg-3"></div>

        <div class="col-lg-6">

          <div class="">
            <div class="contact-about">
              <h3>Disable Account</h3>
            </div>
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
          
            <form action="/account/disable-account/confirm" method="post">

              {{ csrf_field() }}

              <div class="form-group">
                <center><h4>Are you sure to disable your own account?</h4>
                <p>This action will end your session and archive your account. Please review this action before confirming.</p>
                <hr class="br-2">
                <p>You may contact the System Administrator to recover your account after disabling.</p></center>
                <input type="hidden" name="userid" id="userid" value="{{ $customer->id }}">
              </div>
                
              
              <div class="text-center">
                <button type="submit">Reset</button>
              </div>
              <br>

            </form>
            </div>

          </div>
         
        </div>
      </div>
    </section><!-- #contact -->

@endsection