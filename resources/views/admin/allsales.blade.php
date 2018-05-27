@extends ('layout.admin-main')

@section ('title', 'Sales')

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
		<li><a href="/orders">Orders</a></li>
		<li class="active"><a href="/current-sales">Sales</a></li>
	  	<li><a href="/pos">POS</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Sales</h4>
	            <p class="category">All sales from on-site and online transactions are shown.</p>
	        </div>
	        <div class="card-content table-responsive">
	        	<div class="col-lg-4">
	        		<select class="form-control" id="chooseFilter">
	        			<option value="0">Transaction ID</option>
	        			<option value="2">Customer Name</option>
	        			<option value="3">Handled By</option>
	        			<option value="4">Order Placed</option>
	        		</select>
	        	</div>
	        	<div class="col-lg-8">
                    <input type="text" class="form-control" id="orderInput" onkeyup="orderSearch()" placeholder="Search...">
                </div>
				<table id="tblOrders" class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Transaction ID</th>
							<th>Total Purchase Cost</th>
							<th>Customer</th>
							<th>Handled By</th>
							<th>Order Placed</th>
							<th>Reference</th>
							<th>Transaction Date</th>
						</tr>
					</thead>
					<tbody>

					@if ($sales->isEmpty())
					<tr>
						<td colspan="8"><center><b>No transactions to show.</b></center></td>
					</tr>

					@else

						@foreach ($sales as $order)

						<tr>
							<td><a href="/orders/details/{{ substr($order->reference, 10) }}" target="_blank">{{ $order->trans_id }}</a></td>
							<td>{{ $order->total_cost }}</td>
							<td>{{ $order->cust_email }}</td>
							<td>{{ $order->handled_by }}</td>
							<td>{{ $order->order_placed }}</td>
							<td>{{ $order->reference }}</td>
							<td>{{ $order->trans_date }}</td>
						</tr>

						@endforeach

					@endif

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Sold Eggs</h4>
	            <p class="category">All eggs sales from on-site and online transactions are shown.</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Transaction ID</th>
							<th>Egg Size</th>
							<th>Quantity</th>
							<th>From Batch No.</th>
							<th>Batch ID</th>
							<th>Transaction Date and Time</th>
						</tr>
					</thead>
					<tbody>

					@if ($soldeggs->isEmpty())
					<tr>
						<td colspan="8"><center><b>No transactions to show.</b></center></td>
					</tr>

					@else

						@foreach ($soldeggs as $order)

						<tr>
							<td><a href="/orders/details/$order->trans_id }}" target="_blank">{{ $order->trans_id }}</a></td>
							<td>{{ $order->size }}</td>
							<td>{{ $order->quantity }}</td>
							<td>{{ $order->batch_no }}</td>
							<td>{{ $order->batch_id }}</td>
							<td>{{ $order->trans_date }} {{ $order->trans_time }}</td>
						</tr>

						@endforeach

					@endif

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

@endsection

@section ('scripts')

<script>

	function orderSearch() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  var choose = $('#chooseFilter').val();
	  input = document.getElementById("orderInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tblOrders");
	  tr = table.getElementsByTagName("tr");

	  // Search
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[choose];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}

</script>

@endsection