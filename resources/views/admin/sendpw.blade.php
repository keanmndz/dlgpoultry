<!DOCTYPE html>
    <html lang="en-US">
      <head>
          <meta charset="utf-8">
      
          <!-- Laravel App CSS -->
          <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

          <!-- Bootstrap core CSS     -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

          <!--  Material Dashboard CSS    -->
          <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />

          <!--     Fonts and icons     -->
          <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
          <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

      </head>
      
      <body>
          <div class="row">
            <div class="col-lg-12">
              <h2>Hello, {{ $fname }} {{ $lname }}!</h2>
              <h3>Thanks for signing up! It's great to have you at DLG Poultry Farms.</h3>
              <p>Your temporary password is: <b>{{ $pass }}</b><br>
              Copy and paste this on the password field. Please change your password as soon as you access your account.</p><br>
              <p>To more fresh eggs, everyday!</p>
            </div>
          </div>
      </body>
    </html>