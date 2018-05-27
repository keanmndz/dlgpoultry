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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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
        <h1><a href="/" class=""><img src="img/logo.png" alt="" height="50"></a></h1>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="/">Home</a></li>
          <li><a href="/#about">About Us</a></li>
          <li><a href="/#features">Products</a></li>
          <li><a href="/#contact">Contact Us</a></li>
          <li><a href="/register">Register</a></li>
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
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>
  <script src="enduser/lib/easing/easing.min.js"></script>
  <script src="enduser/lib/wow/wow.min.js"></script>
  <script src="enduser/lib/superfish/hoverIntent.js"></script>
  <script src="enduser/lib/superfish/superfish.min.js"></script>
  <script src="enduser/lib/magnific-popup/magnific-popup.min.js"></script>

  <!-- Template Main Javascript File -->
  <script src="enduser/js/main.js"></script>

</body>
</html>