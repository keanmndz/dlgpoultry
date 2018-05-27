<!doctype html>
<html lang="en">
	<head>
		 <meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Quantity Sold Report</title>
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
			<center><h3>Quantity Sold</h3>


<!-- 			<table border="1px" cellpadding="10px" width="100%">
			<tr>
				<td colspan="9"><center><b>RETAIL</b></td>
			</tr>

					<tr>
						<th>Customer</th>
						<th>Jumbo</th>
						<th>Extra Large</th>
						<th>Large</th>
						<th>Medium</th>
						<th>Small</th>
						<th>Peewee</th>
						<th>Broken</th>
						<th>Employee</th>
					</tr>

					@if($salesPDFmaxorder==0)
					<tr>
						<td colspan="9"><center>No data to show</center></td>
					</tr>

					@else

					@for ($i = 0; $i < $salesPDFmaxorder; $i++)

					<tr>
						<td>{{$salesPDFcust[$i]->fname}} {{$salesPDFcust[$i]->lname}}</td>

						foreach($salesPDForder[$i]->cust_email as $a)
						
						@if($salesPDFdetail[$i]->product_name == "Jumbo Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Extra Large Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Large Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Medium Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Small Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Peewee Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Broken Eggs" && $salesPDFdetail[$i]->quantity < 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif



						<td>{{$salesPDForder[$i]->handled_by}}</td>

						
					</tr>


					@endfor
					@endif

				</table> -->

				<br>


				<table border="1px" cellpadding="10px" width="100%">
					<tr>
						<!-- <td colspan="9"><center><b>WHOLESALE</b></center></td> -->
						<td colspan="9"><center><b>EGGS</b></center></td>
					</tr>

					<tr>
						<th>Customer</th>
						<th>Jumbo</th>
						<th>Extra Large</th>
						<th>Large</th>
						<th>Medium</th>
						<th>Small</th>
						<th>Peewee</th>
						<th>Broken</th>
						<th>Employee</th>
					</tr>

					@if($salesPDFmaxorder==0)
					<tr>
						<td colspan="9"><center>No data to show</center></td>
					</tr>

					@else

					@for ($i = 0; $i < $salesPDFmaxorder; $i++)

					<tr>
						<td>{{$salesPDFcust[$i]->fname}} {{$salesPDFcust[$i]->lname}}</td>
						
						@if($salesPDFdetail[$i]->product_name == "Jumbo Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Extra Large Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Large Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Medium Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Small Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Peewee Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Broken Eggs" && $salesPDFdetail[$i]->quantity >= 30)
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						<td>{{$salesPDForder[$i]->handled_by}}</td>
						
					</tr>

					@endfor
					@endif

				</table>

				<br>


				<table border="1px" cellpadding="10px" width="100%">
					<tr>
						<td colspan="5"><center><b>EXTRA</b></center></td>
					</tr>

					<tr>
						<th>Customer</th>
						<th>Cull</th>
						<th>Manure</th>
						<th>Sacks</th>
						<th>Employee</th>
					</tr>

					@if($salesPDFmaxorder==0)
					<tr>
						<td colspan="5"><center>No data to show</center></td>
					</tr>

					@else

					@for ($i = 0; $i < $salesPDFmaxorder; $i++)

					<tr>
						<td>{{$salesPDFcust[$i]->fname}} {{$salesPDFcust[$i]->lname}}</td>
						
						@if($salesPDFdetail[$i]->product_name == "Cull")
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Manure")
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						@if($salesPDFdetail[$i]->product_name == "Sacks")
						<td>{{$salesPDFdetail[$i]->quantity}}</td>
						@else
						<td>0</td>
						@endif

						<td>{{$salesPDForder[$i]->handled_by}}</td>
						
					</tr>

					@endfor
					@endif

				</table>

		</main>
		
	</body>

</html>