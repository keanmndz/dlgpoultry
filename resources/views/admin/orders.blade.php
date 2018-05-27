@extends ('layout.admin-main')

@section ('title', 'Orders')

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
		<li class="active"><a href="/orders">Orders</a></li>
		<li><a href="/current-sales">Sales</a></li>
	  	<li><a href="/pos">POS</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Orders</h4>
	            <p class="category">Online orders are shown.</p>
	        </div>
	        <div class="card-content table-responsive">
	        	<div class="col-lg-4">
	        		<select class="form-control" id="chooseFilter">
	        			<option value="0">Order ID</option>
	        			<option value="2">Customer Name</option>
	        			<option value="3">Handled By</option>
	        			<option value="4">Order Placed</option>
	        			<option value="6">Status</option>
	        		</select>
	        	</div>
	        	<div class="col-lg-8">
                    <input type="text" class="form-control" id="orderInput" onkeyup="orderSearch()" placeholder="Search...">
                </div>
				<table id="tblOrders" class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Order ID</th>
							<th>Total Purchase Cost</th>
							<th>Customer</th>
							<th>Handled By</th>
							<th>Order Placed</th>
							<th>Order Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					@if ($orders->isEmpty())
					<tr>
						<td colspan="8"><center><b>No orders to show.</b></center></td>
					</tr>

					@else

						@foreach ($orders as $order)

						<tr>
							<td><a href="/orders/details/{{ $order->order_id }}" target="_blank">{{ $order->order_id }}</a></td>
							<td>{{ $order->total_cost }}</td>
							<td>{{ $order->cust_email }}</td>
							<td>{{ $order->handled_by }}</td>
							<td>{{ $order->order_placed }}</td>
							<td>{{ $order->trans_date }}</td>
							<td>{{ $order->status }}</td>
							<td class="td-actions text-right">
								@if ($order->status == 'Reserved')
								<button type="button" rel="tooltip" title="Confirm" class="btn btn-success btn-simple btn-xs" onclick="window.location.href='/orders/confirm-reservation/{{ $order->id }}'">
									<i class="material-icons">check</i>
								</button>
								<button type="button" rel="tooltip" title="Cancel" class="btn btn-danger btn-simple btn-xs" onclick="window.location.href='/orders/cancel-reservation/{{ $order->id }}'">
									<i class="material-icons">clear</i>
								</button>
								@else
								<button type="button" rel="tooltip" title="Confirm" class="btn btn-success btn-simple btn-xs" disabled>
									<i class="material-icons">check</i>
								</button>
								<button type="button" rel="tooltip" title="Cancel" class="btn btn-danger btn-simple btn-xs" disabled>
									<i class="material-icons">clear</i>
								</button>
								@endif
							</td>
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