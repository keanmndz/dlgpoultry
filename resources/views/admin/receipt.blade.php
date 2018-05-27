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
          <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
          <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

      </head>
      
      <body>
          <div class="row">
            <div class="col-lg-12">
              <h2>Hello, {{ $data->cust_email }}!</h2>
              <h3>Thank you for your purchase at DLG Poultry Farms!</h3>
              <p>Details of your purchase is listed below.</p><br>
              <table border="1">
                <thead>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Subtotal</th>
                </thead>
                <tbody>
                  @foreach ($details as $orders)

                  <tr>
                    <td>{{ $orders->product_name }}</td>
                    <td>{{ $orders->quantity }}</td>
                    <td>{{ $orders->unit_price }}</td>
                    <td>{{ $orders->unit_price * $orders->quantity }}</td>
                  </tr>

                  @endforeach

                  <tr>
                    <th colspan="3">Total Purchase Cost:</th>
                    <td>{{ $data->total_cost }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </body>
    </html>