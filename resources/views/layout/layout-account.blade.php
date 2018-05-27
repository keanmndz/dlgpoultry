<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>DLG Farms</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700|Open+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{ asset('enduser/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
  <link href="{{ asset('enduser/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('enduser/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('enduser/lib/magnific-popup/magnific-popup.css') }}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{ asset('enduser/css/style.css') }}" rel="stylesheet">

</head>

<body>

<!--==========================
    Header
  ============================-->
  <header id="header" class="header-fixed">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="/"><img src="img/logo.png" alt="" height="50"></a></h1>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="/account">Hello, {{ $customer->fname }}!</a></li>
          <li><a href="/logout">Logout</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

@yield('content')

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
            &copy; Copyright <strong>Team MAD</strong>. All Rights Reserved
          </div>
          <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Avilon
            -->
           
          </div>
        </div>
        <div class="col-lg-6">
          <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
            <a href="#intro" class="scrollto">Home</a>
            <a href="#about" class="scrollto">About</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a>
          </nav>
        </div>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="enduser/lib/jquery/jquery.min.js"></script>
  <script src="enduser/lib/jquery/jquery-migrate.min.js"></script>
  <script src="enduser/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="enduser/lib/easing/easing.min.js"></script>
  <script src="enduser/lib/wow/wow.min.js"></script>
  <script src="enduser/lib/superfish/hoverIntent.js"></script>
  <script src="enduser/lib/superfish/superfish.min.js"></script>
  <script src="enduser/lib/magnific-popup/magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="enduser/js/main.js"></script>

</body>
</html>