@extends ('layout.admin-main')

@section ('title', 'Point-Of-Sale (POS)')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
		<li><a href="/orders">Orders</a></li>
		<li><a href="/current-sales">Sales</a></li>
	  	<li class="active"><a href="/pos">POS</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">
	<div class="col-lg-6 col-md-6">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Items</h4>
	            <p class="category">Select products for purchase.</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover" id="itemSell">
					<thead class="text-primary bold">
						<tr>
							<th>Item Name</th>
							<th>Retail Price</th>
							<th>Wholesale Price</th>
							<th>Available Stock</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					@if ($inv->isEmpty())
					<tr>
						<td colspan="5"><center><b>No items to show.</b></center></td>
					</tr>

					@else

						@foreach ($inv as $item)

						<tr>
							<td>{{ $item->name }}</td>
							<td>P{{ $item->retail_price }}</td>
							<td>P{{ $item->wholesale_price }}</td>
							<td>{{ $item->stocks }}</td>
							<td class="td-actions text-right">
								<button type="button" rel="tooltip" title="Add This" class="btn btn-success btn-simple btn-xs add-modal" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-retail="{{ $item->retail_price }}" data-wholesale="{{ $item->wholesale_price }}" data-stocks="{{ $item->stocks }}">
									<i class="material-icons">add_circle_outline</i>
								</button>
							</td>
						</tr>

						@endforeach

					@endif


					</tbody>
				</table>
			</div>
		</div>
		<br>
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Eggs</h4>
	            <p class="category">Select products for purchase.</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover" id="itemSell">
					<thead class="text-primary bold">
						<tr>
							<th>Item Name</th>
							<th>Retail Price</th>
							<th>Wholesale Price</th>
							<th>Available Stock</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					@if ($eggs->isEmpty())
					<tr>
						<td colspan="5"><center><b>No items to show.</b></center></td>
					</tr>

					@else

						@foreach ($eggs as $item)

						<tr>
							<td>{{ $item->name }}</td>
							<td>P{{ $item->retail_price }}</td>
							<td>P{{ $item->wholesale_price }}</td>
							<td>{{ $item->stocks }}</td>
							<td class="td-actions text-right">
								<button type="button" rel="tooltip" title="Add This" class="btn btn-success btn-simple btn-xs add-modal" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-retail="{{ $item->retail_price }}" data-wholesale="{{ $item->wholesale_price }}" data-stocks="{{ $item->stocks }}">
									<i class="material-icons">add_circle_outline</i>
								</button>
							</td>
						</tr>

						@endforeach

					@endif


					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Item List</h4>
	            <p class="category">Confirm current order.</p>
	        </div>
	        <div class="card-content">

				<table class="table table-responsive table-hover" id="items">
					<thead class="text-primary bold">
						<tr>
							<th>Item Name</th>
							<th>Order Quantity</th>
							<th>Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						
						@if ($orders->isEmpty())
						<tr>
							<td colspan="4"><center><b>No current orders.</b></center></td>
						</tr>
						@else

						@foreach ($orders as $order)
						<tr>
							<td>{{ $order->product_name }}</td>
							<td>{{ $order->quantity }}</td>
							<td>P{{ $order->order_price }}</td>
							<td class="td-actions text-right">
								<button type="button" rel="tooltip" title="Cancel This" class="btn btn-danger btn-simple btn-xs" onclick="window.location.href='/pos/cancel/{{ $order->id }}'">
                                    <i class="material-icons">remove_circle_outline</i>
                                </button>
							</td>
						</tr>
						@endforeach
						
						@endif

					</tbody>
				</table>
				
				<table class="table table-responsive">
					<thead class="text-primary bold">
						<th>Total Amount</th>
						<th>Amount Due</th>
					</thead>
					<tbody>
						<td>P<i class="no-italics" id="totalAmt">{{ $total_order }}</i></td>
						<td>P<i class="no-italics" id="amtDue"></i></td>
					</tbody>
				</table>
				
				<div class="col-sm-6 form-group">
					<label class="control-label">Cash:</label>
					<input type="text" id="payAmt" class="form-control">
				</div>

				<div class="col-sm-6 form-group">
					<label class="control-label">Change:</label>
					<input type="text" id="payChange" class="form-control" disabled>
				</div>

				
				<hr class="break">


				<center><button type="button" class="btn btn-info btn-md confirm-modal" id="confirmOrder" disabled>Confirm Order</button>&ensp;<button type="button" class="btn btn-danger btn-md" onclick="window.location.href='/pos/cancel'">Cancel Order</button></center>

			</div>
		</div>
	</div>

</div>

<!-- Quantity Modal -->
  <div class="modal fade" id="quantAdd" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Enter Quantity</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}
			
				<div class="row">
					<div class="form-group">
						<small class="text-center">Note: Minimum quantity for wholesale is 30 items.</small>
					</div>

					<div class="form-group col-lg-12">
						<label for="quantity_add">Quantity:</label>
						<input type="text" id="quantity_add" class="form-control" required>
						<p class="errorQuantity text-center alert alert-danger hidden"></p>
					</div>

					<input type="hidden" id="itemID">
					<input type="hidden" id="itemName">
					<input type="hidden" id="itemWholesale">
					<input type="hidden" id="itemRetail">
					<input type="hidden" id="itemStocks">

				</div>
	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default add-close" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info add-this" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- Confirm Modal -->
  <div class="modal fade" id="orderConfirm" role="dialog">
    <div class="modal-dialog modal-md">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Confirm Current Order</h3>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}
				
				<div class="container-fluid">
				  <ul class="nav nav-tabs">
				    <li class="active"><a data-toggle="tab" href="#exist">Existing Customer</a></li>
				    <li><a data-toggle="tab" href="#newcust">New Customer</a></li>
				  </ul>

				  <div class="tab-content">
				    <div id="exist" class="tab-pane fade in active">
					    <div class="form-group">
					    	@if (Session::has('reserve'))
						    	<label for="custEmail">Customer Email:</label>&ensp;
								<input class="form-control" id="custEmail" type="text" value="{{ Session::get('reserve')['cust_email'] }}" disabled>
								<input type="hidden" id="confirmReserve" value="{{ Session::get('reserve')['order_id'] }}">
							@else

								<label for="customerAcc">Customer Name:</label>&ensp;
								<select class="customer-acc" id="customerAcc" style="width: 80%">
									<option></option>
									@if (!$cust->isEmpty())

										@foreach ($cust as $custs)
										<option value="{{ $custs->id }}">{{ $custs->fname }} {{ $custs->lname }} ({{ $custs->email }})</option>
										@endforeach

									@endif
								</select>
							@endif
						</div>

						<div class="card">
							<h4>Order Summary</h4>
					    	<div class="card-content table-responsive">
				                <table class="table table-hover">
				                    <thead class="text-primary bold">
				                    	<tr>
					                        <th>Item Description</th>
					                        <th>Qty</th>
					                        <th>Price per Item</th>
					                        <th>Total</th>
				                    	</tr>
				                    </thead>
				                    <tbody>
				                    
				                    @if ($orders->isEmpty())
				                    	<tr>
				                    		<td colspan="4"><center><b>None to show.</b></center></td>
				                    	</tr>
				                    @else

				                    @foreach ($orders as $item)

					                     <tr>
					                        <td>{{ $item->product_name }}</td>
					                        <td>{{ $item->quantity }}</td>
					                        <td>{{ $item->unit_price }}</td>
					                        <td>{{ $item->order_price }}</td>
					                    </tr>

					                @endforeach

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Total Amount</b></td>
					                    	<td>{{ $item->total }}</td>
					                    </tr>

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Cash</b></td>
					                    	<td><i class="no-italics" id="paidAmt"></i></td>
					                    </tr>

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Change</b></td>
					                    	<td><i class="no-italics" id="amtChange"></i></td>
					                    </tr>
					                @endif

				                    </tbody>
				                </table>
					        </div>
					    </div>
				    </div>
				    <div id="newcust" class="tab-pane fade">
				    
					    <div class="card">
					    	<h4>Order Summary</h4>
					    	<div class="card-content table-responsive">
				                <table class="table table-hover">
				                    <thead class="text-primary bold">
				                    	<tr>
					                        <th>Item Description</th>
					                        <th>Qty</th>
					                        <th>Price per Item</th>
					                        <th>Total</th>
				                    	</tr>
				                    </thead>
				                    <tbody>
				                    
				                    @if ($orders->isEmpty())
				                    	<tr>
				                    		<td colspan="4"><center><b>None to show.</b></center></td>
				                    	</tr>
				                    @else

				                    @foreach ($orders as $item)

					                     <tr>
					                        <td>{{ $item->product_name }}</td>
					                        <td>{{ $item->quantity }}</td>
					                        <td>{{ $item->unit_price }}</td>
					                        <td>{{ $item->order_price }}</td>
					                    </tr>

					                @endforeach

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Total Amount</b></td>
					                    	<td>{{ $item->total }}</td>
					                    </tr>

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Cash</b></td>
					                    	<td><i class="no-italics" id="paidAmt1"></i></td>
					                    </tr>

					                    <tr>
					                    	<td colspan="3" class="text-right bold"><b>Change</b></td>
					                    	<td><i class="no-italics" id="amtChange1"></i></td>
					                    </tr>
					                @endif

				                    </tbody>
				                </table>

								<input type="hidden" id="custNew" value="One-time">

					        </div>
					    </div>    
				    
				    </div>
				  </div>
				</div>

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default confirm-close" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info confirm-this" data-dismiss="modal">Order</button>
	        </div>

      </div>

    </div>
  </div>

@endsection

@section ('scripts')

<script src="{{ asset('js/pos.js') }}"></script>

@endsection