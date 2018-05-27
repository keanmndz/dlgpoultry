@extends ('layout.admin-main')

@section ('title', 'Inventory > Eggs')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
	  <li><a href="/inventory">Items</a></li>
	  <li class="active"><a href="/inventory/eggs">Eggs</a></li>
	  <li><a href="/inventory/chickens">Chickens</a></li>
	  <li><a href="/inventory/pullets">Pullets</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">
	<div class="col-lg-8">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Egg Batches</h4>
					<p class="category">Egg count for each fresh batch entry.</p>
			  </div>
			  <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Batch</th>
							<th>Jumbo</th>
							<th>Extra Large</th>
							<th>Large</th>
							<th>Medium</th>
							<th>Small</th>
							<th>Peewee</th>
							<th>Soft-shell</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						@if ($inv->isEmpty())
						<tr>
							<td colspan="7"><center><b>No items to show.</b></center></td>
						</tr>

						@else

							@foreach ($inv as $item)

							<tr>
								<td>{{ $item->batch_id }}</td>
								<td>{{ $item->jumbo }}</td>
								<td>{{ $item->xlarge }}</td>
								<td>{{ $item->large }}</td>
								<td>{{ $item->medium }}</td>
								<td>{{ $item->small }}</td>
								<td>{{ $item->peewee }}</td>
								<td>{{ $item->softshell }}</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs view-modal" data-added="{{ $item->added_by }}" data-life="{{ $item->lifetime }}" data-name="Batch {{ $item->batch_id }}" data-datetime="{{ $item->created_at }}">
										<i class="material-icons">info_outline</i>
								  	</button>
								  	<button type="button" rel="tooltip" title="Edit Quantity" class="btn btn-warning btn-simple btn-xs edit-modal" data-id="{{ substr($item->batch_id, -1) }}" data-batchid="{{ $item->batch_id }}" data-jumbo="{{ $item->jumbo }}" data-xlarge="{{ $item->xlarge }}" data-large="{{ $item->large }}" data-medium="{{ $item->medium }}" data-small="{{ $item->small }}" data-peewee="{{ $item->peewee }}" data-softshell="{{ $item->softshell }}">
										<i class="material-icons">edit</i>
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

	<div class="col-lg-4">
		<div class="card">
			  <div class="card-header" data-background-color="green">
					<h4 class="title">Actions</h4>
					<!-- <p class="category">Here is a subtitle for this table</p> -->
			  </div>
			  <div class="card-content">
				<ul class="list-group">
					<li class="list-group-item action-tab add-modal"><b>Add New Batch</b></li>
					<li class="list-group-item action-tab update-modal"><b>Reduce Quantity</b></li>
				</ul>
            </div>
		</div>
	</div>

</div>

<div class="row">
	<div class="col-lg-6 col-md-12">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Reject Eggs</h4>
					<p class="category">Quantities of reject eggs from different batches.</p>
			  </div>
			  <div class="card-content table-responsive container-fluid">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Batch</th>
							<th>Quantity</th>
							<th>Remarks</th>
							<th>Added By</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						@if ($reject->isEmpty())
						<tr>
							<td colspan="6"><center><b>No items to show.</b></center></td>
						</tr>

						@else

							@foreach ($reject as $item)

							<tr>
								<td>{{ substr($item->batch_id, -1) }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->remarks }}</td>
								<td>{{ $item->added_by }}</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs edit-modal1" data-id="{{ substr($item->batch_id, -1) }}" data-batchid="{{ $item->batch_id }}" data-quantity="{{ $item->quantity }}" data-type="reject">
										<i class="material-icons">edit</i>
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

	<div class="col-lg-6 col-md-12">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Broken Eggs</h4>
					<p class="category">Quantities of broken eggs from different batches.</p>
			  </div>
			  <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Quantity</th>
							<th>Remarks</th>
							<th>Added By</th>
							<th>Date Added</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						@if ($broken->isEmpty())
						<tr>
							<td colspan="6"><center><b>No items to show.</b></center></td>
						</tr>

						@else

							@foreach ($broken as $item)

							<tr>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->remarks }}</td>
								<td>{{ $item->added_by }}</td>
								<td>{{ $item->created_at }}</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs edit-modal2" data-id="{{ $item->id }}" data-quantity="{{ $item->quantity }}" data-type="broken">
										<i class="material-icons">edit</i>
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
				<table class="table">
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

<!-- ADD MODAL -->
  <div class="modal fade" id="addInv" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Batch Count</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}

	        	<br>
				
				<div class="row">

					<div class="col-lg-3">
						<label>Batch No.:</label>
						<select class="choose-batch" id="bldgid_add" style="width: 100%">
							@foreach ($batches as $item)
							<option>{{ $item->batch }}</option>
							@endforeach
						</select>
						<p class="errorBldg text-center alert alert-danger hidden"></p>
					</div>					

					<div class="col-lg-3">
						<label>Jumbo:</label>
						<input type="text" id="jumbo_add" class="form-control" required>
						<p class="errorJumbo text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Extra Large:</label>
						<input type="text" id="xlarge_add" class="form-control" required>
						<p class="errorXlarge text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Large:</label>
						<input type="text" id="large_add" class="form-control" required>
						<p class="errorLarge text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">

					<div class="col-lg-3">
						<label>Medium:</label>
						<input type="text" id="medium_add" class="form-control" required>
						<p class="errorMedium text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Small:</label>
						<input type="text" id="small_add" class="form-control" required>
						<p class="errorSmall text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Peewee:</label>
						<input type="text" id="peewee_add" class="form-control" required>
						<p class="errorPeewee text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Soft-shelled:</label>
						<input type="text" id="softshell_add" class="form-control" required>
						<p class="errorSoft text-center alert alert-danger hidden"></p>
					</div>

				</div>

				<div class="row">
					<div class="form-group col-lg-3">
						<label>Reject:</label>
						<input type="text" id="reject_add" class="form-control" required>
						<p class="errorReject text-center alert alert-danger hidden"></p>
					</div>

					<div class="form-group col-lg-9">
						<label>Remarks:</label>
						<select class="form-control" id="remarks_add">
							<option>Fresh from Batch</option>
							<option>Returned Eggs</option>
							<option>Others</option>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<label class="hidden" id="remLabel">Remarks Description:</label>
						<textarea class="form-control hidden" id="remarks_add1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks text-center alert alert-danger hidden"></p>
					</div>
				</div>
	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default add-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info add-this" data-dismiss="modal">Add</button>
	        </div>

      </div>

    </div>
  </div>


<!-- UPDATE MODAL -->
<div class="modal fade" id="updateInv" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reduce Quantity</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}

	        	<br>
				
				<div class="row">				

					<div class="col-lg-4">
						<label>Jumbo:</label>
						<input type="text" id="jumbo_update" class="form-control" required>
						<p class="errorJumbo1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-4">
						<label>Extra Large:</label>
						<input type="text" id="xlarge_update" class="form-control" required>
						<p class="errorXlarge1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-4">
						<label>Large:</label>
						<input type="text" id="large_update" class="form-control" required>
						<p class="errorLarge1 text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">

					<div class="col-lg-3">
						<label>Medium:</label>
						<input type="text" id="medium_update" class="form-control" required>
						<p class="errorMedium1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Small:</label>
						<input type="text" id="small_update" class="form-control" required>
						<p class="errorSmall1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Peewee:</label>
						<input type="text" id="peewee_update" class="form-control" required>
						<p class="errorPeewee1 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Soft-shelled:</label>
						<input type="text" id="softshell_update" class="form-control" required>
						<p class="errorSoft1 text-center alert alert-danger hidden"></p>
					</div>

				</div>

				<div class="row">
					<div class="form-group col-lg-12">
						<label>Remarks:</label>
						<select class="form-control" id="remarks_update">
							<option>Broken</option>
							<option>Got Stolen</option>
							<option>Personal Use</option>
							<option>Rotten</option>
							<option>Eaten by Rats</option>
							<option>Others</option>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<label class="hidden" id="remLabel1">Remarks Description:</label>
						<textarea class="form-control hidden" id="remarks_update1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks1 text-center alert alert-danger hidden"></p>
					</div>
				</div>
	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default update-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info update-this" data-dismiss="modal">Update</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- EDIT MODAL -->
<div class="modal fade" id="editInv" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Entry</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}

	        	<br>
				
				<div class="row">

					<div class="col-lg-3">
						<label>Batch No.:</label>
						<select id="batch_edit" style="width: 100%">
							@foreach ($batches as $item)
							<option>{{ $item->batch }}</option>
							@endforeach
						</select>
						<p class="errorBatch text-center alert alert-danger hidden"></p>
					</div>					

					<div class="col-lg-3">
						<label>Jumbo:</label>
						<input type="text" id="jumbo_edit" class="form-control" required>
						<p class="errorJumbo2 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Extra Large:</label>
						<input type="text" id="xlarge_edit" class="form-control" required>
						<p class="errorXlarge2 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Large:</label>
						<input type="text" id="large_edit" class="form-control" required>
						<p class="errorLarge2 text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">

					<div class="col-lg-3">
						<label>Medium:</label>
						<input type="text" id="medium_edit" class="form-control" required>
						<p class="errorMedium2 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Small:</label>
						<input type="text" id="small_edit" class="form-control" required>
						<p class="errorSmall2 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Peewee:</label>
						<input type="text" id="peewee_edit" class="form-control" required>
						<p class="errorPeewee2 text-center alert alert-danger hidden"></p>
					</div>

					<div class="col-lg-3">
						<label>Soft-shelled:</label>
						<input type="text" id="softshell_edit" class="form-control" required>
						<p class="errorSoft2 text-center alert alert-danger hidden"></p>
					</div>

				</div>

				<div class="row">
					<div class="form-group col-lg-12">
						<label>Remarks:</label>
						<select class="form-control" id="remarks_edit">
							<option>Wrong Batch Number</option>
							<option>Mistyped Entry</option>
							<option>Others</option>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<label class="hidden" id="remLabel2">Remarks Description:</label>
						<textarea class="form-control hidden" id="remarks_edit1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks2 text-center alert alert-danger hidden"></p>
					</div>
				</div>
				
				<input type="hidden" id="batchid_edit">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default edit-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info edit-this" data-dismiss="modal">Edit</button>
	        </div>

      </div>

    </div>
  </div>

<!-- EDIT1 MODAL -->
<div class="modal fade" id="editInv1" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Entry</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}

	        	<br>
				
				<div class="row">

					<div class="col-lg-6">
						<label>Batch No.:</label>
						<select id="batch_edit1" style="width: 100%">
							@foreach ($batches as $item)
							<option>{{ $item->batch }}</option>
							@endforeach
						</select>
						<p class="errorBatch1 text-center alert alert-danger hidden"></p>
					</div>					

					<div class="col-lg-6">
						<label>Quantity:</label>
						<input type="text" id="quantity_edit" class="form-control" required>
						<p class="errorQuantity text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">
					<div class="form-group col-lg-12">
						<label>Remarks:</label>
						<select class="form-control" id="remarks_edit2">
							<option>Wrong Batch Number</option>
							<option>Mistyped Entry</option>
							<option>Others</option>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<label class="hidden" id="remLabel3">Remarks Description:</label>
						<textarea class="form-control hidden" id="remarks_edit3" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorRemarks3 text-center alert alert-danger hidden"></p>
					</div>
				</div>
				
				<input type="hidden" id="batchid_edit1">
				<input type="hidden" id="type">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default edit-close1" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info edit-this1" data-dismiss="modal">Edit</button>
	        </div>

      </div>

    </div>
  </div>

  <!-- EDIT2 MODAL -->
<div class="modal fade" id="editInv2" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Entry</h4>
        </div>

	        <div class="modal-body">

	        	{{ csrf_field() }}

	        	<br>
				
				<div class="row">			

					<div class="col-lg-12">
						<label>Quantity:</label>
						<input type="text" id="quantity_edit1" class="form-control" required>
						<p class="errorQuantity1 text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">
					<div class="form-group col-lg-12">
						<label>Remarks:</label>
						<select class="form-control" id="editRemarks">
							<option>Mistyped Entry</option>
							<option>Others</option>
						</select>
					</div>
					<div class="form-group col-lg-12">
						<label class="hidden" id="remLabel4">Remarks Description:</label>
						<textarea class="form-control hidden" id="editRemarks1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="errorEdit text-center alert alert-danger hidden"></p>
					</div>
				</div>
				
				<input type="hidden" id="id1">
				<input type="hidden" id="type1">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default edit-close2" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info edit-this2" data-dismiss="modal">Edit</button>
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
								<td id="datetime"></td>
							</tr>
							<tr>
								<th>Batch Lifetime:</th>
								<td id="life_more"></td>
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

<script>

	$(document).ready(function() {
	    $('.choose-batch').select2();
	});

    // add item
    $(document).on('click', '.add-modal', function() {

        $('#addInv').modal('show');

    });

    $('#remarks_add').change(function() {
    	var option = $(this).find("option:selected").val();

    	if (option == 'Others')
    	{
    		$('#remarks_add1').removeClass('hidden');
    		$('#remLabel').removeClass('hidden');
    	}

    	else
    	{
    		$('#remarks_add1').addClass('hidden');
    		$('#remLabel').addClass('hidden');
    	}
    });

    $('.modal-footer').on('click', '.add-this', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/eggs/add',
            data: {
            	'batch_id': $('#bldgid_add').val(),
            	'jumbo': $('#jumbo_add').val(),
            	'xlarge': $('#xlarge_add').val(),
            	'large': $('#large_add').val(),
            	'medium': $('#medium_add').val(),
            	'small': $('#small_add').val(),
            	'peewee': $('#peewee_add').val(),
            	'softshell': $('#softshell_add').val(),
            	'reject': $('#reject_add').val(),
            	'remarks': $('#remarks_add').val() + '. ' + $('#remarks_add1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#addInv').modal('show');
            		$('.modal-footer').on('click', '.add-close', function () {
                        window.location.href = "/inventory/eggs";
                    });

            		if(data.errors.batch_id) {
            			$('.errorBldg').removeClass('hidden');
                        $('.errorBldg').text(data.errors.batch_id);
            		}

            		if(data.errors.jumbo) {
            			$('.errorJumbo').removeClass('hidden');
                        $('.errorJumbo').text(data.errors.jumbo);
            		}

            		if(data.errors.xlarge) {
            			$('.errorXlarge').removeClass('hidden');
                        $('.errorXlarge').text(data.errors.xlarge);
            		}

            		if(data.errors.medium) {
            			$('.errorMedium').removeClass('hidden');
                        $('.errorMedium').text(data.errors.medium);
            		}

            		if(data.errors.small) {
            			$('.errorSmall').removeClass('hidden');
                        $('.errorSmall').text(data.errors.small);
            		}

            		if(data.errors.peewee) {
            			$('.errorPeewee').removeClass('hidden');
                        $('.errorPeewee').text(data.errors.peewee);
            		}

            		if(data.errors.large) {
            			$('.errorLarge').removeClass('hidden');
                        $('.errorLarge').text(data.errors.large);
            		}

            		if(data.errors.softshell) {
            			$('.errorSoft').removeClass('hidden');
                        $('.errorSoft').text(data.errors.softshell);
            		}

            		if(data.errors.reject) {
            			$('.errorReject').removeClass('hidden');
                        $('.errorReject').text(data.errors.reject);
            		}

            		if(data.errors.remarks) {
            			$('.errorRemarks').removeClass('hidden');
                        $('.errorRemarks').text(data.errors.remarks);
            		}

            	}

            	else {

                $('#success').text('Successfully added this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}
            }
        });
    });

    // update item
    $(document).on('click', '.update-modal', function() {

        $('#updateInv').modal('show');

    });

    $('#remarks_update').change(function() {
    	var option = $(this).find("option:selected").val();

    	if (option == 'Others')
    	{
    		$('#remarks_update1').removeClass('hidden');
    		$('#remLabel1').removeClass('hidden');
    	}

    	else
    	{
    		$('#remarks_update1').addClass('hidden');
    		$('#remLabel1').addClass('hidden');
    	}
    });

    // update
    $('.modal-footer').on('click', '.update-this', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/eggs/update',
            data: {
            	'jumbo': $('#jumbo_update').val(),
            	'xlarge': $('#xlarge_update').val(),
            	'large': $('#large_update').val(),
            	'medium': $('#medium_update').val(),
            	'small': $('#small_update').val(),
            	'peewee': $('#peewee_update').val(),
            	'softshell': $('#softshell_update').val(),
            	'remarks': $('#remarks_update').val() + '. ' + $('#remarks_update1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#updateInv').modal('show');
            		$('.modal-footer').on('click', '.update-close', function () {
                        window.location.href = "/inventory/eggs";
                    });

            		if(data.errors.jumbo) {
            			$('.errorJumbo1').removeClass('hidden');
                        $('.errorJumbo1').text(data.errors.jumbo);
            		}

            		if(data.errors.xlarge) {
            			$('.errorXlarge1').removeClass('hidden');
                        $('.errorXlarge1').text(data.errors.xlarge);
            		}

            		if(data.errors.medium) {
            			$('.errorMedium1').removeClass('hidden');
                        $('.errorMedium1').text(data.errors.medium);
            		}

            		if(data.errors.small) {
            			$('.errorSmall1').removeClass('hidden');
                        $('.errorSmall1').text(data.errors.small);
            		}

            		if(data.errors.peewee) {
            			$('.errorPeewee1').removeClass('hidden');
                        $('.errorPeewee1').text(data.errors.peewee);
            		}

            		if(data.errors.large) {
            			$('.errorLarge1').removeClass('hidden');
                        $('.errorLarge1').text(data.errors.large);
            		}

            		if(data.errors.softshell) {
            			$('.errorSoft1').removeClass('hidden');
                        $('.errorSoft1').text(data.errors.softshell);
            		}

            		if(data.errors.remarks) {
            			$('.errorRemarks1').removeClass('hidden');
                        $('.errorRemarks1').text(data.errors.remarks);
            		}

            	}

            	else if ((data.error)) {
            		$('#errormsg').text(data.error);
	                $('#modalError').modal('show');
	                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}

            	else {

                $('#success').text('Successfully updated this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}
            }
        });
    });

    // view more info
	$(document).on('click', '.view-modal', function() {
	    $('#life_more').text($(this).data('life'));
	    $('#added_more').text($(this).data('added'));
	    $('#datetime').text($(this).data('datetime'));
	    $('.viewName').text($(this).data('name'));
	    $('#viewInv').modal('show');
	});

	// edit item
    $(document).on('click', '.edit-modal', function() {

    	$('#batchid_edit').val($(this).data('batchid'));
    	$('#batch_edit').val($(this).data('id'));
    	$('#jumbo_edit').val($(this).data('jumbo'));
    	$('#xlarge_edit').val($(this).data('xlarge'));
    	$('#large_edit').val($(this).data('large'));
    	$('#medium_edit').val($(this).data('medium'));
    	$('#small_edit').val($(this).data('small'));
    	$('#peewee_edit').val($(this).data('peewee'));
    	$('#softshell_edit').val($(this).data('softshell'));
    	$('#batchid_edit').val($(this).data('batchid'));
        $('#editInv').modal('show');

    });

    $('#remarks_edit').change(function() {
    	var option = $(this).find("option:selected").val();

    	if (option == 'Others')
    	{
    		$('#remarks_edit1').removeClass('hidden');
    		$('#remLabel2').removeClass('hidden');
    	}

    	else
    	{
    		$('#remarks_edit1').addClass('hidden');
    		$('#remLabel2').addClass('hidden');
    	}
    });

    // edit
    $('.modal-footer').on('click', '.edit-this', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/eggs/edit',
            data: {
            	'id': $('#batch_edit').val(),
            	'batch_id': $('#batchid_edit').val(),
            	'jumbo': $('#jumbo_edit').val(),
            	'xlarge': $('#xlarge_edit').val(),
            	'large': $('#large_edit').val(),
            	'medium': $('#medium_edit').val(),
            	'small': $('#small_edit').val(),
            	'peewee': $('#peewee_edit').val(),
            	'softshell': $('#softshell_edit').val(),
            	'remarks': $('#remarks_edit').val() + '. ' + $('#remarks_edit1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#editInv').modal('show');
            		$('.modal-footer').on('click', '.edit-close', function () {
                        window.location.href = "/inventory/eggs";
                    });

            		if(data.errors.jumbo) {
            			$('.errorJumbo2').removeClass('hidden');
                        $('.errorJumbo2').text(data.errors.jumbo);
            		}

            		if(data.errors.xlarge) {
            			$('.errorXlarge2').removeClass('hidden');
                        $('.errorXlarge2').text(data.errors.xlarge);
            		}

            		if(data.errors.medium) {
            			$('.errorMedium2').removeClass('hidden');
                        $('.errorMedium2').text(data.errors.medium);
            		}

            		if(data.errors.small) {
            			$('.errorSmall2').removeClass('hidden');
                        $('.errorSmall2').text(data.errors.small);
            		}

            		if(data.errors.peewee) {
            			$('.errorPeewee2').removeClass('hidden');
                        $('.errorPeewee2').text(data.errors.peewee);
            		}

            		if(data.errors.large) {
            			$('.errorLarge2').removeClass('hidden');
                        $('.errorLarge2').text(data.errors.large);
            		}

            		if(data.errors.softshell) {
            			$('.errorSoft2').removeClass('hidden');
                        $('.errorSoft2').text(data.errors.softshell);
            		}

            		if(data.errors.remarks) {
            			$('.errorRemarks2').removeClass('hidden');
                        $('.errorRemarks2').text(data.errors.remarks);
            		}

            	}

            	else {

                $('#success').text('Successfully updated this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}
            }
        });
    });

    // edit reject item
    $(document).on('click', '.edit-modal1', function() {

    	$('#batchid_edit1').val($(this).data('batchid'));
    	$('#batch_edit1').val($(this).data('id'));
    	$('#quantity_edit').val($(this).data('quantity'));
    	$('#type').val($(this).data('type'));
        $('#editInv1').modal('show');

    });

    $('#remarks_edit2').change(function() {
    	var option = $(this).find("option:selected").val();

    	if (option == 'Others')
    	{
    		$('#remarks_edit3').removeClass('hidden');
    		$('#remLabel3').removeClass('hidden');
    	}

    	else
    	{
    		$('#remarks_edit3').addClass('hidden');
    		$('#remLabel3').addClass('hidden');
    	}
    });

    // edit
    $('.modal-footer').on('click', '.edit-this1', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/eggs/edit-other',
            data: {
            	'id': $('#batch_edit1').val(),
            	'batch_id': $('#batchid_edit1').val(),
            	'quantity': $('#quantity_edit').val(),
            	'type': $('#type').val(),
            	'remarks': $('#remarks_edit2').val() + '. ' + $('#remarks_edit3').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#editInv1').modal('show');
            		$('.modal-footer').on('click', '.edit-close1', function () {
                        window.location.href = "/inventory/eggs";
                    });

            		if(data.errors.quantity) {
            			$('.errorQuantity').removeClass('hidden');
                        $('.errorQuantity').text(data.errors.quantity);
            		}
            	}

            	else {

                $('#success').text('Successfully updated this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}
            }
        });
    });

    // edit broken item
    $(document).on('click', '.edit-modal2', function() {

    	$('#id1').val($(this).data('id'));
    	$('#quantity_edit1').val($(this).data('quantity'));
    	$('#type1').val($(this).data('type'));
        $('#editInv2').modal('show');

    });

    $('#editRemarks').change(function() {
    	var option = $(this).find("option:selected").val();

    	if (option == 'Others')
    	{
    		$('#editRemarks1').removeClass('hidden');
    		$('#remLabel4').removeClass('hidden');
    	}

    	else
    	{
    		$('#editRemarks').addClass('hidden');
    		$('#remLabel4').addClass('hidden');
    	}
    });

    // edit
    $('.modal-footer').on('click', '.edit-this2', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/eggs/edit-other',
            data: {
            	'id': $('#id1').val(),
            	'type': $('#type1').val(),
            	'batch_id': $('#id1').val(),
            	'quantity': $('#quantity_edit1').val(),
            	'remarks': $('#editRemarks').val() + '. ' + $('#editRemarks1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#editInv2').modal('show');
            		$('.modal-footer').on('click', '.edit-close1', function () {
                        window.location.href = "/inventory/eggs";
                    });

            		if(data.errors.quantity) {
            			$('.errorQuantity1').removeClass('hidden');
                        $('.errorQuantity1').text(data.errors.quantity);
            		}

            		if(data.errors.remarks) {
            			$('.errorEdit').removeClass('hidden');
                        $('.errorEdit').text(data.errors.remarks);
            		}

            	}

            	else {

                $('#success').text('Successfully updated this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/eggs";
                    });
            	}
            }
        });
    });


</script>

@endsection