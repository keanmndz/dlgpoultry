<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>DLG Poultry Farm Management System - @yield ('title')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    @yield ('token')

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link href="{{ asset('img/apple-icon.png') }}" rel="apple-touch-icon">

    <!-- Laravel App CSS/JS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

    <!-- JQuery -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

</head>

<body>

    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="{{ asset('img/sidebar-1.jpg') }}">
    
    <!-- Other colors for "data color": purple | blue | green | orange | red

        You can also add an image using data-image tag -->

            <div class="logo">
                <a href="/admin" class="simple-text">
                    DLG Poultry Farm <br> Management System
                </a>
                <hr class="br-2">
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">

                    @if ($view_name == 'admin.index')
                    <li class="active">
                    @else
                    <li>
                    @endif
                    <a href="/admin/dash">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if ($user->access == 'Veterinarian')
                        
                        @if ($view_name == 'admin.vetmeds')
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="/vet/medicines">
                                <i class="material-icons">content_paste</i>
                                <p>Medicines</p>
                            </a>
                        </li>

                        @if ($view_name == 'admin.production')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/production">
                                    <i class="material-icons">show_chart</i>
                                    <p>Production</p>
                                </a>
                            </li>

                            @if ($view_name == 'admin.population')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/population">
                                    <i class="material-icons">bubble_chart</i>
                                    <p>Population</p>
                                </a>
                            </li>

                    @else


                        @if ($view_name == 'admin.pos' || $view_name == 'admin.orders')
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="/orders">
                                <i class="material-icons">assignment</i>
                                <p>Sales Management</p>
                            </a>
                        </li>

                        @if ($view_name == 'admin.inventory' || $view_name == 'admin.inveggs' || $view_name == 'admin.invchickens' || $view_name == 'admin.invpullets')
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="/inventory">
                                <i class="material-icons">content_paste</i>
                                <p>Inventory</p>
                            </a>
                        </li>

                        @if ($view_name == 'admin.customers' || $view_name == 'admin.custcreate')
                        <li class="active">
                        @else
                        <li>
                        @endif
                            <a href="/customers">
                                <i class="material-icons">group</i>
                                <p>Customers</p>
                            </a>
                        </li>

                        @if ($user->access != 'Farm Hand')
                            @if ($view_name == 'admin.production')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/production">
                                    <i class="material-icons">show_chart</i>
                                    <p>Production</p>
                                </a>
                            </li>

                            @if ($view_name == 'admin.population')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/population">
                                    <i class="material-icons">bubble_chart</i>
                                    <p>Population</p>
                                </a>
                            </li>

                            @if ($view_name == 'admin.sales')
                            <li class="active">
                            @else
                            <li>
                            @endif
                                <a href="/sales">
                                    <i class="material-icons">attach_money</i>
                                    <p>Sales</p>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-panel">
           <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand page-title" href="#"> @yield ('title') </a>
                    </div>
                    <div class="collapse navbar-collapse navbar-form">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown" id="markasread" onclick="markNotifAsRead()">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    @if (count(Auth::user()->unreadNotifications) != 0)
                                        <span class="notification">{{ count(Auth::user()->unreadNotifications) }}</span>
                                    @endif
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <ul class="dropdown-menu">
                                
                                @if (count(Auth::user()->unreadNotifications) == 0)
                                    <li><a href=""><b>No notifications.</b></a></li>
                                @else
                                    @foreach (Auth::user()->unreadNotifications as $notif)
                                    <li>
                                        @include('layout.notifications.'.snake_case(class_basename($notif->type)))
                                    </li>
                                    @endforeach
                                @endif
                                </ul>
                            </li>
                            <li class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    {{ $user->fname }} {{ $user->lname }}
                                </a>
                                <ul class="dropdown-menu">
                                   <li>
                                      <a href="{{ url('/admin/details') }}"><i class="material-icons">face</i>&emsp;User Panel</a>
                                   </li>
                                   <li>
                                      <a href="{{ url('/admin/logout') }}"><i class="material-icons">exit_to_app</i>&emsp;Log Out</a>
                                   </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
                        <!-- @if ($view_name != 'admin.index' && $view_name != 'admin.pos')
                        Search is needed on other views instead of dashboard
                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </form>
                        @endif -->

            <div class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>

            <footer class="footer">

                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="/admin/dash">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="/" target="_blank">
                                    View Website
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#">Keena and Serine of Team MAD
                    </p>
                </div>
            </footer>
        </div>
    </div>

<!-- Success Modal via JQuery -->
<div id="myModal2" class="modal fade" role="dialog">
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
        <p id="success"></p>
        <small>Note: Your action may be under approval.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close-this" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@if (Session::has('success'))

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
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

$(document).ready(function(){
    $("#myModal").modal("toggle");
});

</script>

@endif

<!-- Modal -->
<div id="modalError" class="modal fade" role="dialog">
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
        <p id="errormsg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close-this" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

</body>

@yield ('scripts')

<!-- Laravel App JS -->
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<!--   Core JS Files   -->
<script src=".{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>

<!--  Dynamic Elements plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.js"></script>

<!--  PerfectScrollbar Library -->
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js"></script>

<!-- Material Dashboard javascript methods -->
<script src="{{ asset('js/material-dashboard.js') }}"></script>

<!-- Chart.js (for the charts) plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>

<!-- Select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

<!-- Moment.js plugin (for date and time) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment.js"></script>

<!-- Custom Scripts -->
<script src="{{ asset('js/notif.js') }}"></script>

</html>
