<!doctype html>
<html lang="en">
	<head>
		 <meta charset="utf-8" />
    	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Production Report</title>
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
			<center><h3>Production Report</h3></center>

				<table border="1px" cellpadding="10px" width="100%">
					<tr>
						<th>Batch</th>
						<th>Peewee</th>
						<th>Small</th>
						<th>Medium</th>
						<th>Large</th>
						<th>Extra Large</th>
						<th>Jumbo</th>
						<th>Soft-shelled</th>
						<th>Lifetime</th>
					</tr>


					@if($prodPDFcount==0)
					<tr>
						<td colspan="9"><center>No data to show</center></td>
					</tr>

					@else

					@foreach($prodPDFeggs as $prod)
						<tr>
							<td>{{$prod->batch_id}}</td>
							<td>{{$prod->peewee}}</td>
							<td>{{$prod->small}}</td>
							<td>{{$prod->medium}}</td>
							<td>{{$prod->large}}</td>
							<td>{{$prod->xlarge}}</td>
							<td>{{$prod->jumbo}}</td>
							<td>{{$prod->softshell}}</td>
							<td>{{$prod->lifetime}}</td>
						</tr>
					@endforeach

					<tr>
							<td>Total on-hand</td>
							<td>{{$prod->total_peewee}}</td>
							<td>{{$prod->total_small}}</td>
							<td>{{$prod->total_medium}}</td>
							<td>{{$prod->total_large}}</td>
							<td>{{$prod->total_xlarge}}</td>
							<td>{{$prod->total_jumbo}}</td>
							<td>{{$prod->total_softshell}}</td>
							<td>---</td>
						</tr>

						

					@endif

				</table>

				<br><br><br>

				<div class="row">
					<table border="1px" cellpadding="10px" width="48%">
					<tr>
						<th>Date and Time</th>
						<th>Broken Eggs</th>
						<th>Remarks</th>
					</tr>

					@if($prodPDFcount==0)
					<tr>
						<td colspan="3"><center>No data to show</center></td>
					</tr>

					@else

					@foreach($prodPDFbroken as $broken)
						<tr>
							<td>{{$broken->created_at}}</td>
							<td>{{$broken->quantity}}</td>
							<td>{{$broken->remarks}}</td>
						</tr>
					@endforeach

					<tr>
						<td><b>Total</b></td>
						<td>{{$broken->total}}</td>
						<td>---</td>
					</tr>
					

					@endif

					</table>

				</div>

				&nbsp;&nbsp;

				<div class="row">
					<table border="1px" cellpadding="10px" width="48%">
					<tr>
						<th>Batch</th>
						<th>Reject</th>
						<th>Remarks</th>
					</tr>

					@if($prodPDFcountrjk==0)
					<tr>
						<td colspan="3"><center>No data to show</center></td>
					</tr>

					@else

					@foreach($prodPDFreject as $reject)
						<tr>
							<td>{{$reject->batch_id}}</td>
							<td>{{$reject->quantity}}</td>
							<td>{{$reject->remarks}}</td>
						</tr>
					@endforeach

					<tr>
						<td><b>Total</b></td>
						<td>{{$reject->total}}</td>
						<td>---</td>
					</tr>

					

					@endif

				</table>

				</div>

				<br>
				<p><b>Customer Returns: {{$prodPDFreturn}} </b></p>



		</main>
		
	</body>

</html>