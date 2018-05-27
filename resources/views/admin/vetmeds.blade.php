@extends ('layout.admin-main')

@section ('title', 'Medicines')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="row">

	<div class="col-lg-8">
		<!-- Content Start -->
			<div class="card">
		        <div class="card-header" data-background-color="blue">
		            <h4 class="title">Medicines</h4>
		            <!-- <p class="category">Here is a subtitle for this table</p> -->
		        </div>
		        <div class="card-content table-responsive">
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
									<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-name="{{ $item->name }}" data-create="{{ $item->created_at }}" data-update="{{ $item->updated_at }}" data-added="{{ $item->added_by }}" data-expiry="{{ $item->expiry }}">
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
	
	<div class="col-lg-4">
		<div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Actions</h4>
                <!-- <p class="category">Card subtitle</p> -->
            </div>
            <div class="card-content">
				<ul class="list-group">
					<li class="list-group-item action-tab add-modal1" data-type="meds"><b>Add New Medicine</b></li>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#updatePrice"><b>Update Item Price</b></li>
					<div class="collapse" id="updatePrice">
						<br>
						<div class="container-fluid">
							<label for="itemprice">Item Name:</label><br>
							<select class="choose-item" id="itemprice" style="width: 100%"> 
						        <option></option> 
						 
						        @if(!$meds->isEmpty()) 
						        <optgroup label="Medicines"> 
						        @foreach ($meds as $med) 
						          <option value="{{ $med->id }}" data-type="meds" data-name="{{ $med->name }}">{{ $med->name }}</option> 
						        @endforeach 
						        </optgroup> 
						        @endif 
						 
						    </select> 
							<div class="form-group">	
								<label for="price_update">Price:</label><br>
								<input type="number" id="price_update" class="form-control" min="0">
								<p class="errorPrice3 text-center alert alert-danger hidden"></p><br>
							</div>
							<br>
							<label for="itemprice_remarks">Item Name:</label><br>
							<select class="itemp-remarks" id="itemprice_remarks" style="width: 100%"> 
						        <option></option> 
						       	<option>Higher Selling Price</option>
						       	<option>Lower Selling Price</option>  
						    </select> 

							<center><button type="button" class="btn btn-sm btn-default cancel-this" data-toggle="collapse" data-target="#updatePrice">Cancel</button><button type="button" class="btn btn-sm btn-success update-this">Update</button></center>
						</div>
					</div>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#updateReorder"><b>Update Item Reorder Level</b></li>
						<div class="collapse" id="updateReorder">
						<br>
						<div class="container-fluid">
							<label for="itemr">Item Name:</label><br>
							<select class="choose-itemr" id="itemr" style="width: 100%"> 
						        <option></option> 

						        @if(!$meds->isEmpty()) 
						        <optgroup label="Medicines"> 
						        @foreach ($meds as $med) 
						          <option value="{{ $med->id }}" data-type="meds" data-name="{{ $med->name }}">{{ $med->name }}</option> 
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
								<th>Expiry Date:</th>
								<td id="expiry_date"></td>
							</tr>
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

<script src="{{ asset('js/vet.js') }}"></script>

@endsection