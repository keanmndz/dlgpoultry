
<!doctype html>
<html lang="en">
	<head>
		 <meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Sales Report</title>
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    	<meta name="viewport" content="width=device-width" />

		<!-- Favicons -->
		<link href="{{ asset('img/favicon.png') }}" rel="icon">
		<link href="{{ asset('img/apple-icon.png') }}" rel="apple-touch-icon">

		<style>
			@page {
			 	margin: 100px 25px;

			}

			.page-break {
			    page-break-after: always;
			}

			@font-face {
			    font-family: 'Arial';
			    font-weight: normal;
			    font-style: normal;
			    font-variant: normal;
			}
			
			body {
				font-family: Arial, sans-serif;
			}

			
			.tbl-header {
				margin-left: auto;
				margin-right: auto;
				border-bottom: 3px solid black;
			}

			.tbl-footer {
				border-top: 3px solid black;
			}

			table {
			    font-family: arial, sans-serif;
			    font-size: 14px;
			}

			td, th {
			    padding: 8px;
			}

			tr:nth-child(even) {
			    background-color: #dddddd;
			}


			main {
				margin-top: 60px;
				position: fixed;
			}

			header {
				position: fixed;
				top: -80px; 
				left: 0px; 
				right: 0px; 
				height: 50px;
			}
			
			footer {
				position: fixed;
				bottom: -90px; 
				left: 0px; 
				right: 0px; 
				height: 50px;
			}

		</style>

	</head>
	<body>
		<header>
			<table class="tbl-header">
				<tr>
					<td>
						<img src="img/logo.png" alt="" height="100">
					</td>
					<td>
						<b>DLG Poultry Farms</b><br>
						737 U Mojares St., Brgy. Lodlod, Lipa City, Batangas <b>|</b> (043) 784-2337
					</td>
				</tr>
			</table>
		</header>

		<footer>
			<table class="tbl-footer">
				<tr>
					<td><small><i>Date Generated: {{ now() }}</i></small></td>
				</tr>
			</table>
		</footer>
		
		<main>
			<center><h3>Sales Report</h3>


			<table border="1px" cellpadding="10px" width="100%">
				<tr>
					<th>Transaction ID</th>
					<th>Total Purchase Cost</th>
					<th>Customer</th>
					<th>Order Placed</th>
					<th>Reference</th>
					<th>Transaction Date</th>
					<th>Handled By</th>
				</tr>

				@if($salesPDFmaxorder==0)
				<tr>
					<td colspan="9"><center>No data to show</center></td>
				</tr>

				@else

				@for ($i = 0; $i < $salesPDFmaxorder; $i++)

				<tr>
					<td>{{$salesPDForder[$i]->trans_id}}</td>
					<td>{{$salesPDForder[$i]->total_cost}}</td>
					<td>{{$salesPDFcust[$i]->fname}} {{$salesPDFcust[$i]->lname}}</td>
					<td>{{$salesPDForder[$i]->order_placed}}</td>
					<td>{{$salesPDForder[$i]->reference}}</td>
					<td>{{$salesPDForder[$i]->trans_date}}</td>
					<td>{{$salesPDForder[$i]->handled_by}}</td>

					
				</tr>


					@endfor
					@endif

				</table>

		</main>
		
	</body>

</html>