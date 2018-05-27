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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

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

                <p class="text-center">Enter your new password.</p>

                <form action="/admin/reset-pw/confirm" method="post">

                    {{ csrf_field() }}

                    <div class="form-group label-floating">
                        <label class="control-label">Password</label>
                        <input class="form-control" type="password" id="password" name="password" required autofocus>
                    </div>

                    <div class="form-group label-floating">
                        <label class="control-label">Repeat Password</label>
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <input type="hidden" value="{{ $user->id }}" id="userid" name="userid">

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-lg btn-info">Reset</button>
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
