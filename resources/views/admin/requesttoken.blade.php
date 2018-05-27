<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ URL::asset('img/favicon.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DLG Poultry Farm Management System</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Laravel App CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    <!-- JQuery -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <img src="{{ asset('img/logo.png') }}" class="img-fluid img-logo" alt="DLG Poultry Farm">
            </div>
        </div>

        <div class="row space">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 login-form">
                <h3 class="text-center">Reset your password.</h3>
                <hr class="break">

                <p class="text-center">Enter the email you use upon login. You will receive an email for the next steps if your email is valid. You may also contact your Manager or System Administrator to reset your password.</p>

                <form action="/admin/send-fpw" method="post">

                    {{ csrf_field() }}

                    <div class="form-group label-floating">
                        <label class="control-label">Email Address</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-lg btn-info">Request</button>
                        <p><small>Or, go back to <a href="/admin">login.</a></small></p>
                    </div>

                </form>

                <!--  Error handle -->
                @if($errors->any())

                <div class="alert alert-danger text-center">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                </div>
                @endif
                
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>

    @if (Session::has('wrong'))

    <!-- Modal -->
    <div id="wrongModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-small">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
             <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
              <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
              <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
              <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
            </svg>
            <br>
                <h3 class="modal-title">Error!</h3>
          </div>
          <div class="modal-body">
            <p id="wrong">{{ Session::get('wrong') }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <script>

    $(document).ready(function(){
        $("#wrongModal").modal("toggle");
    });

    </script>

    @endif

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright text-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="#">DLG Poultry Farm - Team MAD
                </p>
            </div>
        </footer>

</body>

<!-- Laravel App JS -->
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<!--   Core JS Files   -->
<script src=".{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>

<!--  PerfectScrollbar Library -->
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{ asset('js/material-dashboard.js?v=1.2.0') }}"></script>

</html>
