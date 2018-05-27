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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

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
                <h3 class="text-center">Login.</h3>
                <hr class="break">

                <form action="/admin/login" method="post">

                    {{ csrf_field() }}

                    <div class="form-group label-floating">
                        <label class="control-label">Email Address</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group label-floating">
                        <label class="control-label">Password</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <p class="text-center"><small><a href="/admin/request-token">Forgot your password?</a></small></p>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-lg btn-info">Login</button>
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

                
                @if (Session::has('success'))

                 <!-- Modal -->
                <div id="modalSuccess" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-small">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                        </svg>
                        <br>
                            <h3 class="modal-title">Success!</h3>
                      </div>
                      <div class="modal-body">
                        <p id="success">{{ Session::get('success') }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>

                <script>
                    
                    $(document).ready(function () {
                        $('#modalSuccess').modal('toggle');
                    });

                </script>

                @endif
                
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>

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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>

<!--  PerfectScrollbar Library -->
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>

<!-- Material Dashboard javascript methods -->
<script src="{{ asset('js/material-dashboard.js?v=1.2.0') }}"></script>

</html>
