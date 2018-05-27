@extends ('layout.admin-main')

@section ('title', 'Inventory')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
		<li class="active"><a href="/inventory">Items</a></li>
	  <li><a href="/inventory/eggs">Eggs</a></li>
	  <li><a href="/inventory/chickens">Chickens</a></li>
	  <li><a href="/inventory/pullets">Pullets</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">

	<div class="col-lg-8">
		<div class="card card-nav-tabs">
			<div class="card-header" data-background-color="green">
				<div class="nav-tabs-navigation">
					<div class="nav-tabs-wrapper">
						<span class="nav-tabs-title"><b>Tabs:</b></span>
						<ul class="nav nav-tabs" data-tabs="tabs">
							<li class="active">
								<a href="#feeds" data-toggle="tab">
									Feeds
								<div class="ripple-container"></div></a>
							</li>
							<li class="">
								<a href="#meds" data-toggle="tab">
									Medicines
								<div class="ripple-container"></div></a>
							</li>
							<li class="">
								<a href="#supplies" data-toggle="tab">
									Supplies
								<div class="ripple-container"></div></a>
							</li>
							<li class="">
								<a href="#products" data-toggle="tab">
									Products
								<div class="ripple-container"></div></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="card-content">

				<div class="tab-content">
					<div class="tab-pane active" id="feeds">
						<!-- Content Start -->

							<div class="card">
						        <div class="card-header" data-background-color="blue">
						            <h4 class="title">Feeds</h4>
						            <!-- <p class="category">Here is a subtitle for this table</p> -->
						        </div>
						        <div class="card-content table-responsive">
									<div class="row">
					                    <div class="col-lg-12">
					                        <input type="text" class="form-control" id="myInputInv" onkeyup="myFunction()" placeholder="Search...">
					                    </div>
					                </div>

									<table id="myTable" class="table">
										<thead class="text-primary bold">
											<tr>
												<th>Item Description</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Reorder Level</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										@if ($feeds->isEmpty())
										<tr>
											<td colspan="5"><center><b>No items to show.</b></center></td>
										</tr>

										@else

											@foreach ($feeds as $item)

											<tr>
												<td>{{ $item->name }}</td>
												<td>{{ $item->price }}</td>
												<td>{{ $item->quantity }} {{ $item->unit }}</td>
												<td>{{ $item->reorder_level }}</td>
												<td class="td-actions text-right">
													<button type="button" rel="tooltip" title="Add Quantities" class="btn btn-success btn-simple btn-xs more-modal" data-id="{{ $item->id }}" data-type="feeds" data-name="{{ $item->name }}">
														<i class="material-icons">add_circle_outline</i>
													</button>
													<button type="button" rel="tooltip" title="Use Item" class="btn btn-warning btn-simple btn-xs use-modal" data-id="{{ $item->id }}" data-type="feeds" data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">
														<i class="material-icons">update</i>
													</button>
													<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-name="{{ $item->name }}" data-create="{{ $item->created_at }}" data-update="{{ $item->updated_at }}" data-added="{{ $item->added_by }}">
															<i class="material-icons">info_outline</i>
													</button>
												</td>
											</tr>

											@endforeach

										@endif
										</tbody>
									</table>
								</div>
							</div>
						<!-- Content End -->
					</div>

					<div class="tab-pane" id="meds">
						<!-- Content Start -->
							<div class="card">
						        <div class="card-header" data-background-color="blue">
						            <h4 class="title">Medicines</h4>
						            <!-- <p class="category">Here is a subtitle for this table</p> -->
						        </div>
						        <div class="card-content table-responsive">
						        	<div class="col-lg-12">
				                        <input type="text" class="form-control" id="myInputMeds" onkeyup="myFunctionMeds()" placeholder="Search...">
				                    </div>
									<table id="myTableMeds" class="table">
										<thead class="text-primary bold">
											<tr>
												<th>Item Description</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Reorder Level</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										@if ($meds->isEmpty())
										<tr>
											<td colspan="5"><center><b>No items to show.</b></center></td>
										</tr>

										@else

											@foreach ($meds as $item)

											<tr>
												<td>{{ $item->name }}</td>
												<td>{{ $item->price }}</td>
												<td>{{ $item->quantity }} {{ $item->unit }}</td>
												<td>{{ $item->reorder_level }}</td>
												<td class="td-actions text-right">
													<button type="button" rel="tooltip" title="Add Quantities" class="btn btn-success btn-simple btn-xs more-modal" data-id="{{ $item->id }}" data-type="meds" data-name="{{ $item->name }}">
														<i class="material-icons">add_circle_outline</i>
													</button>
													<button type="button" rel="tooltip" title="Use Item" class="btn btn-warning btn-simple btn-xs use-modal" data-id="{{ $item->id }}" data-type="meds" data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">
														<i class="material-icons">update</i>
													</button>
													<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-name="{{ $item->name }}" data-create="{{ $item->created_at }}" data-update="{{ $item->updated_at }}" data-added="{{ $item->added_by }}">
															<i class="material-icons">info_outline</i>
													</button>
												</td>
											</tr>

											@endforeach

										@endif

										</tbody>
									</table>
								</div>
							</div>
						<!-- Content End -->
					</div>

					<div class="tab-pane" id="supplies">
						<!-- Content Start -->
						<div class="card">
									<div class="card-header" data-background-color="blue">
											<h4 class="title">Farm Supplies</h4>
											<!-- <p class="category">Here is a subtitle for this table</p> -->
									</div>
									<div class="card-content table-responsive">
										<div class="col-lg-12">
					                        <input type="text" class="form-control" id="myInputSupp" onkeyup="myFunctionSupp()" placeholder="Search...">
					                    </div>
										<table id="myTableSupp" class="table table-hover">
											<thead class="text-primary bold">
												<tr>
													<th>Item Description</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>Reorder Level</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>

												@if ($supp->isEmpty())
												<tr>
													<td colspan="5"><center><b>No items to show.</b></center></td>
												</tr>

												@else

													@foreach ($supp as $item)
													
													<tr>
														<td>{{ $item->name }}</td>
														<td>{{ $item->price }}</td>
														<td>{{ $item->quantity }}</td>
														<td>{{ $item->reorder_level }}</td>
														<td class="td-actions text-right">
															<button type="button" rel="tooltip" title="Add Quantities" class="btn btn-success btn-simple btn-xs more-modal" data-id="{{ $item->id }}" data-type="supplies" data-name="{{ $item->name }}">
																<i class="material-icons">add_circle_outline</i>
															</button>
															<button type="button" rel="tooltip" title="Use Item" class="btn btn-warning btn-simple btn-xs use-modal" data-id="{{ $item->id }}" data-type="supplies" data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">
																<i class="material-icons">update</i>
															</button>
															<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-name="{{ $item->name }}" data-create="{{ $item->created_at }}" data-update="{{ $item->updated_at }}" data-added="{{ $item->added_by }}">
																	<i class="material-icons">info_outline</i>
															</button>
														</td>
													</tr>

													@endforeach
												
												@endif

											</tbody>
										</table>
									</div>
						</div>
						<!-- Content End -->
					</div>

					<div class="tab-pane" id="products">
						<!-- Content Start -->
							<div class="card">
						        <div class="card-header" data-background-color="blue">
						            <h4 class="title">Items for Sale</h4>
						            <!-- <p class="category">Here is a subtitle for this table</p> -->
						        </div>
						        <div class="card-content table-responsive">
						        	<div class="col-lg-12">
				                        <input type="text" class="form-control" id="myInputProd" onkeyup="myFunctionProd()" placeholder="Search...">
				                    </div>
									<table id="myTableProd" class="table">
										<thead class="text-primary bold">
											<tr>
												<th>Item Description</th>
												<th>Retail Price</th>
												<th>Wholesale Price</th>
												<th>Available Stock</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										@if ($prods->isEmpty())
										<tr>
											<td colspan="5"><center><b>No items to show.</b></center></td>
										</tr>

										@else

											@foreach ($prods as $item)

											<tr>
												<td>{{ $item->name }}</td>
												<td>{{ $item->retail_price }}</td>
												<td>{{ $item->wholesale_price }}</td>
												<td>{{ $item->stocks }}</td>
												<td class="td-actions text-right">
													@if ($item->name == 'Manure' || $item->name == 'Sacks')							
														<button type="button" rel="tooltip" title="Add Quantities" class="btn btn-success btn-simple btn-xs more-modal" data-id="{{ $item->id }}" data-type="products" data-name="{{ $item->name }}">
															<i class="material-icons">add_circle_outline</i>
														</button>
													@else
														<button type="button" rel="tooltip" title="Add Quantities" class="btn btn-success btn-simple btn-xs" disabled>
															<i class="material-icons">add_circle_outline</i>
														</button>
													@endif
													<button type="button" rel="tooltip" title="Use Item" class="btn btn-warning btn-simple btn-xs use-modal" data-id="{{ $item->id }}" data-type="products" data-name="{{ $item->name }}" data-quantity="{{ $item->quantity }}">
														<i class="material-icons">update</i>
													</button>
													<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-name="{{ $item->name }}" data-create="{{ $item->created_at }}" data-update="{{ $item->updated_at }}" data-added="{{ $item->added_by }}">
															<i class="material-icons">info_outline</i>
													</button>
												</td>
											</tr>

											@endforeach

										@endif

										</tbody>
									</table>
								</div>
							</div>
						<!-- Content End -->
					</div>

				</div>
			</div>

		</div>
	</div>
	
	<div class="col-lg-4">
		<div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Actions</h4>
                <!-- <p class="category">Card subtitle</p> -->
            </div>
            <div class="card-content">
				<ul class="list-group">
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#new"><b>Add New Item</b></li>
					<div class="collapse" id="new">
						<li class="list-group-item action-tab add-modal1" data-type="feeds">Add New Feed</li>
						<li class="list-group-item action-tab add-modal1" data-type="meds">Add New Medicine</li>
						<li class="list-group-item action-tab add-modal2" data-type="supplies">Add New Supply Item</li>
						<li class="list-group-item action-tab add-modal3" data-type="products">Add New Product</li>
					</div>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#updatePrice"><b>Update Item Price</b></li>
					<div class="collapse" id="updatePrice">
						<br>
						<div class="container-fluid">
							<label for="itemprice">Item Name:</label><br>
							<select class="choose-item" id="itemprice" style="width: 100%"> 
						        <option></option> 
						        @if(!$feeds->isEmpty()) 
						        <optgroup label="Feeds"> 
						        @foreach ($feeds as $feed) 
						          <option value="{{ $feed->id }}" data-type="feeds" data-name="{{ $feed->name }}">{{ $feed->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						        @if(!$meds->isEmpty()) 
						        <optgroup label="Medicines"> 
						        @foreach ($meds as $med) 
						          <option value="{{ $med->id }}" data-type="meds" data-name="{{ $med->name }}">{{ $med->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						        @if(!$supp->isEmpty()) 
						        <optgroup label="Supplies"> 
						        @foreach ($supp as $supply) 
						          <option value="{{ $supply->id }}" data-type="supplies" data-name="{{ $supply->name }}">{{ $supply->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif
						 
						    </select> 
							<div class="form-group">	
								<label for="price_update">Price:</label><br>
								<input type="number" id="price_update" class="form-control" min="0">
								<p class="errorPrice3 text-center alert alert-danger hidden"></p><br>
							</div>
							<label for="itemprice_remarks">Remarks:</label><br>
							<select class="itemp-remarks" id="itemprice_remarks" style="width: 100%"> 
						        <option></option> 
						       	<option>Higher Price</option>
						       	<option>Lower Price</option>  
						    </select> 
							<br>
							<center><button type="button" class="btn btn-sm btn-default cancel-this" data-toggle="collapse" data-target="#updatePrice">Cancel</button><button type="button" class="btn btn-sm btn-success update-this">Update</button></center>
						</div>
					</div>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#updateForSale"><b>Update Products Price</b></li>
					<div class="collapse" id="updateForSale">
						<br>
						<div class="container-fluid">
							<label for="itemforsale">Item Name:</label><br>
							<select class="item-forsale" id="itemforsale" style="width: 100%"> 
						        <option></option> 
						        @if(!$prods->isEmpty()) 
						        <optgroup label="Products"> 
						        @foreach ($prods as $prod) 
						          <option value="{{ $prod->id }}" data-type="prods" data-name="{{ $prod->name }}">{{ $prod->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						    </select>
						    <br><br>
						    <label for="itemmode">Mode of Purchase:</label><br>
						    <select class="item-mode" id="itemmode" style="width: 100%"> 
						        <option></option>
						        <option>Retail</option> 
						        <option>Wholesale</option>
						    </select>
							<div class="form-group">	
								<label for="forsale_update">Price:</label><br>
								<input type="number" id="forsale_update" class="form-control" min="0">
								<p class="errorPrice4 text-center alert alert-danger hidden"></p><br>
							</div>
							<label for="forsale_remarks">Remarks:</label><br>
							<select class="itemp-remarks" id="forsale_remarks" style="width: 100%"> 
						        <option></option> 
						       	<option>Higher Selling Price</option>
						       	<option>Lower Selling Price</option>  
						    </select> 
							<br>
							<center><button type="button" class="btn btn-sm btn-default cancel-this" data-toggle="collapse" data-target="#updateForSale">Cancel</button><button type="button" class="btn btn-sm btn-success update-this1">Update</button></center>
						</div>
					</div>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#updateReorder"><b>Update Item Reorder Level</b></li>
						<div class="collapse" id="updateReorder">
						<br>
						<div class="container-fluid">
							<label for="itemr">Item Name:</label><br>
							<select class="choose-itemr" id="itemr" style="width: 100%"> 
						        <option></option> 
						        @if(!$feeds->isEmpty()) 
						        <optgroup label="Feeds"> 
						        @foreach ($feeds as $feed) 
						          <option value="{{ $feed->id }}" data-type="feeds" data-name="{{ $feed->name }}">{{ $feed->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						        @if(!$meds->isEmpty()) 
						        <optgroup label="Medicines"> 
						        @foreach ($meds as $med) 
						          <option value="{{ $med->id }}" data-type="meds" data-name="{{ $med->name }}">{{ $med->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						        @if(!$supp->isEmpty()) 
						        <optgroup label="Supplies"> 
						        @foreach ($supp as $supply) 
						          <option value="{{ $supply->id }}" data-type="supples" data-name="{{ $supply->name }}">{{ $supply->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						    </select> 
							<div class="form-group">	
								<label for="reorder_update">Reorder Level:</label><br>
								<input type="number" id="reorder_update" class="form-control" min="0">
								<p class="errorReorder2 text-center alert alert-danger hidden"></p><br>
							</div>

							<center><button type="button" class="btn btn-sm btn-default cancel-reorder" data-toggle="collapse" data-target="#updateReorder">Cancel</button><button type="button" class="btn btn-sm btn-success update-reorder">Update</button></center>
						</div>
					</div>
				</ul>
            </div>
        </div>
	</div>

</div>

<!-- ACTIVITY LOGS -->

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Activity Log</h4>
					<p class="category">All activities done on this module are recorded and shown below.</p>
			  </div>
			  <div class="card-content table-responsive">
			  	<div class="row">
			  		<div class="col-lg-4">
			  			<select class="form-control" id="chooseFilter">
			  				<option value="0">Item Name</option>
			  				<option value="1">Type</option>
			  				<option value="4">Done By</option>
			  			</select>
			  		</div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="myInputActs" onkeyup="myFunctionActs()" placeholder="Search...">
                    </div>
                </div>
				<table id="myTableActs" class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Item Name</th>
							<th>Type</th>
							<th>Activity</th>
							<th>Remarks</th>
							<th>Done By</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						
						@if ($changes->isEmpty())
						<tr>
							<td colspan="7"><center><b>No entries to show.</b></center></td>
						</tr>
						
						@else

							@foreach ($changes as $item)

							<tr>
								<td>{{ $item->name }}</td>
								<td>{{ $item->type }}</td>
								<td>{{ $item->activity }}</td>
								<td>{{ $item->remarks }}</td>
								<td>{{ $item->user }}</td>
								<td>{{ $item->changed_at }}</td>
							</tr>

							@endforeach

						@endif
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- ADD MODAL FEEDS/MEDS -->
  <div class="modal fade" id="addInv1" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Item</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}
				
				<div class="row">

					<div class="form-group col-lg-6">
						<label for="name">Item Name:</label>
						<input type="text" class="form-control" id="name_add" required autofocus>
						<p class="errorName text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-6">
						<label for="price">Price:</label>
						<input type="text" class="form-control" id="price_add" required>
						<p class="errorPrice text-center alert alert-danger hidden"></p>
					</div>
				
				</div>
			
				<div class="row">

					<div class="form-group col-lg-4">
						<label for="quantity">Quantity:</label>
						<input type="text" id="quantity_add" class="form-control" required>
						<p class="errorQuantity text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-4">
						<label for="unit">Unit of Measurement:</label>
						<select class="form-control" id="unit_add" required>
							<option>grams</option>
							<option>kilograms</option>
							<option>sacks</option>
						</select>
					</div>

					<div class="form-group col-lg-4">
						<label for="reorder">Reorder Level</label>
						<input type="text" class="form-control" id="reorder_add" required>
						<p class="errorReorder text-center alert alert-danger hidden"></p>
					</div>

					<input type="hidden" id="type_add1">

				</div>

				<div class="row">
					<div class="form-group col-lg-12">
						Remarks:
						<textarea class="form-control" id="remarks_add" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks text-center alert alert-danger hidden"></p>
					</div>
				</div>

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default add-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info add-this1" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- ADD MODAL SUPPLIES -->
  <div class="modal fade" id="addInv2" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Item</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}
				
				<div class="row">

					<div class="form-group col-lg-6">
						<label for="name">Item Name:</label>
						<input type="text" class="form-control" id="name_add1" required autofocus>
						<p class="errorName1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-6">
						<label for="price">Price:</label>
						<input type="text" class="form-control" id="price_add1" required>
						<p class="errorPrice1 text-center alert alert-danger hidden"></p>
					</div>

				
				</div>
			
				<div class="row">

					<div class="form-group col-lg-6">
						<label for="quantity">Quantity:</label>
						<input type="text" id="quantity_add1" class="form-control" required>
						<p class="errorQuantity1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-6">
						<label for="reorder">Reorder Level</label>
						<input type="text" class="form-control" id="reorder_add1" required>
						<p class="errorReorder1 text-center alert alert-danger hidden"></p>
					</div>
					
					<input type="hidden" id="type_add2">

				</div>

				<div class="row">
					<div class="form-group col-lg-12">
						Remarks:
						<textarea class="form-control" id="remarks_add1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks1 text-center alert alert-danger hidden"></p>
					</div>
				</div>
	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default add-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info add-this2" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- ADD MODAL PRODUCTS -->
  <div class="modal fade" id="addInv3" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Item</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}
				
				<div class="row">

					<div class="form-group col-lg-12">
						<label for="name">Item Name:</label>
						<input type="text" class="form-control" id="name_add2" required autofocus>
						<p class="errorName2 text-center alert alert-danger hidden"></p>
					</div>
				
				</div>
			
				<div class="row">

					<div class="form-group col-lg-6">
						<label for="price">Retail Price:</label>
						<input type="text" class="form-control" id="retailprice" required>
						<p class="errorRetail text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-6">
						<label for="price">Wholesale Price:</label>
						<input type="text" class="form-control" id="wholesaleprice" required>
						<p class="errorWholesale text-center alert alert-danger hidden"></p>
					</div>
				</div>

				<div class="row">

					<div class="form-group col-lg-12">
						<label for="quantity">Available Stocks:</label>
						<input type="text" id="quantity_add2" class="form-control" required>
						<p class="errorQuantity2 text-center alert alert-danger hidden"></p>
					</div>

				</div>

				<div class="row">
					<div class="form-group col-lg-12">
						Remarks:
						<textarea class="form-control" id="remarks_add2" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks2 text-center alert alert-danger hidden"></p>
					</div>
				</div>

				<input type="hidden" id="type_add3">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default add-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info add-this3" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- USE ITEM -->
  <div class="modal fade" id="useInv" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Use <i class="useName no-italics"></i></h4>
        </div>

	        <div class="modal-body">
				
				<div class="row">

					<div class="form-group col-lg-12">
						Enter quantity to be used:
						<input type="number" id="useInput" class="form-control" min="0">
						<p class="usevalidQuant text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-12">
						<div class="form-group col-lg-12">
							<label>Remarks:</label>
							<select class="form-control choose-remarks" id="remarks_use">
								<option>For Farm Use</option>
								<option>Expired/Damaged</option>
								<option>Personal Use</option>
								<option>Others</option>
							</select>
						</div>
						<div class="form-group col-lg-12">
							<label class="hidden" id="remLabel">Remarks Description:</label>
							<textarea class="form-control hidden" id="remarks_use1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
							<p class="usevalidRemarks text-center alert alert-danger hidden"></p>
						</div>
					</div>
				
				</div>

				<input type="hidden" id="type_use">
				<input type="hidden" id="id_use">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default use-close" data-dismiss="modal">Cancel</button>
	        	<button type="button" class="btn btn-info btn-md use-this" data-dismiss="modal">Use</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- ADD QUANTITY -->
  <div class="modal fade" id="addQuant" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Quantities for <i class="moreName no-italics"></i></h4>
        </div>

	        <div class="modal-body">
				
				<div class="row">

					{{ csrf_field() }}

					<div class="form-group col-lg-12">
						Quantity:
						<input type="number" id="quantity_more" class="form-control" min="0">
						<p class="validQuantity text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-12">
						Remarks:
						<textarea class="form-control" id="remarks_more" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="validRemarks text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<input type="hidden" id="type_more">
				<input type="hidden" id="id_more">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        	<button type="button" class="btn btn-info btn-md add-more" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- VIEW MODAL -->
  <div class="modal fade" id="viewInv" role="dialog">
    <div class="modal-dialog modal-md">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">More Information on <i class="viewName no-italics"></i></h4>
        </div>

	        <div class="modal-body">
				<br>
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-responsive table-hover">
							<tr>
								<th>Added By:</th>
								<td id="added_more"></td>
							</tr>
							<tr>
								<th>Entry Date:</th>
								<td id="created_more"></td>
							</tr>
							<tr>
								<th>Entry Updated as of:</th>
								<td id="updated_more"></td>
							</tr>
						</table>
					</div>
				</div>

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>

      </div>

    </div>
  </div>


@endsection

@section ('scripts')

<script src="{{ asset('js/inventory.js') }}"></script>

@endsection