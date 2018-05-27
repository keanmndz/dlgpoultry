@extends ('layout.admin-main')

@section ('title', 'Order Details')

@section ('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Details for Order ID {{ $order[0]->order_id }}</h4>
	        </div>
	        <div class="card-content table-responsive">
	        	<div class="col-lg-12">
                    <input type="text" class="form-control" id="orderInput" onkeyup="orderSearch()" placeholder="Search item name...">
                </div>
				<table id="tblOrders" class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Quantity</th>
							<th>Product Name</th>
							<th>Unit Price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>

					@if ($order->isEmpty())
					<tr>
						<td colspan="8"><center><b>No orders to show.</b></center></td>
					</tr>

					@else

						@foreach ($order as $orders)

						<tr>
							<td>{{ $orders->quantity }}</td>
							<td>{{ $orders->product_name }}</td>
							<td>{{ $orders->unit_price }}</td>
							<td>{{ number_format($orders->quantity * $orders->unit_price, 2) }}</td>
						</tr>


						@endforeach

					@endif

					<tr>
						<th colspan="3" class="text-right">Total Purchase Cost:</th>
						<th>{{ number_format($total, 2) }}</th>
					</tr>


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
	  input = document.getElementById("orderInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tblOrders");
	  tr = table.getElementsByTagName("tr");

	  // Search
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[1];
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