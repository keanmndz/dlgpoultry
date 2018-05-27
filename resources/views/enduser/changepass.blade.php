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
  
        <div class="col-lg-4"></div>

        <div class="col-lg-4">

          <div class="">
            <div class="contact-about">
              <h3>Reset Now</h3>
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
          
            <form action="/account/change-password/insert" method="post">

              {{ csrf_field() }}

              <div class="form-group">
                Password: <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}" required>
                <br>
                Password: <input type="password" class="form-control" name="password_confirmation" id="password" placeholder="Repeat Password" required>
                <br>
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