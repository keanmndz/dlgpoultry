@extends ('layout.admin-main')

@section ('title', 'Inventory > Pullets')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="container-fluid">
	<ul class="nav nav-pills nav-pills-info">
	  <li><a href="/inventory">Items</a></li>
	  <li><a href="/inventory/eggs">Eggs</a></li>
	  <li><a href="/inventory/chickens">Chickens</a></li>
	  <li class="active"><a href="/inventory/pullets">Pullets</a></li>
	</ul>
</div>

<hr class="br-2">

<div class="row">
	<div class="row">
	<div class="col-lg-8">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Pullets</h4>
					<p class="category">Total number of pullets in each batch.</p>
			  </div>
			  <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Batch</th>
							<th>Quantity</th>
							<th>Date Added</th>
						</tr>
					</thead>
					<tbody>
						
						@if ($total->isEmpty())
						<tr>
							<td colspan="3"><center><b>No items to show.</b></center></td>
						</tr>
						
						@else

							@foreach ($total as $item)

							<tr>
								<td>{{ $item->batch }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->created_at }}</td>
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
					<li class="list-group-item action-tab add-modal"><b>Add New Batch Count</b></li>
					<li class="list-group-item action-tab" data-toggle="collapse" data-target="#update"><b>Reduce Quantity</b></li>
					<div class="collapse" id="update">
						<br>
						<div class="container-fluid">
							<label for="batch_choose">Batch Number:</label><br>
							<select class="choose-batch" id="batch_choose" style="width: 100%">
								<option></option>
								@foreach ($total as $item)
								<option>{{ $item->batch }}</option>
								@endforeach
							</select>
							<div class="form-group">	
								<label for="quantity_update">Quantity:</label><br>
								<input type="number" id="quantity_update" class="form-control" min="0">
								<p class="errorQty1 text-center alert alert-danger hidden"></p><br>
							</div>
							<label for="remarks_update">Remarks:</label><br>
							<select class="choose-batch" id="remarks_update" style="width: 100%">
								<option></option>
								<option>For Transfer</option>
								<option>Got Stolen</option>
								<option>Escaped from Cage</option>
							</select><br><br>
							<center><button type="button" class="btn btn-sm btn-default cancel-this" data-toggle="collapse" data-target="#update">Cancel</button><button type="button" class="btn btn-sm btn-success update-this">Update</button></center>
						</div>
					</div>
				</ul>
            </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Batch Entry History</h4>
					<p class="category">Number of pullets in each batch entry.</p>
			  </div>
			  <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Batch</th>
							<th>Quantity</th>
							<th>Date Added</th>
							<th>Maturity</th>
							<th>Remarks</th>
							<th>Added By</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

						@if ($inv->isEmpty())
						<tr>
							<td colspan="8"><center><b>No items to show.</b></center></td>
						</tr>

						@else

							@foreach ($inv as $item)

							<tr>
								<td>{{ $item->batch_id }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->date_added }}</td>
								<td>{{ $item->maturity }}</td>
								<td>{{ $item->remarks }}</td>
								<td>{{ $item->added_by }}</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs edit-modal" data-id="{{ substr($item->batch_id, -1) }}" data-batchid="{{ $item->batch_id }}" data-quantity="{{ $item->quantity }}" data-type="pullets">
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

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			  <div class="card-header" data-background-color="blue">
					<h4 class="title">Dead</h4>
					<p class="category">Quantity of dead pullets from each batch.</p>
			  </div>
			  <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>Batch</th>
							<th>Quantity</th>
							<th>Remarks</th>
							<th>Added By</th>
							<th>Date Added</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						
						@if ($dead->isEmpty())
						<tr>
							<td colspan="8"><center><b>No items to show.</b></center></td>
						</tr>
						
						@else

							@foreach ($dead as $item)

							<tr>
								<td>{{ $item->batch_id }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ $item->remarks }}</td>
								<td>{{ $item->added_by }}</td>
								<td>{{ $item->created_at }}</td>
								<td class="td-actions text-right">
									<button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs edit-modal" data-id="{{ $item->batch_id }}" data-quantity="{{ $item->quantity }}" data-type="dead">
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

					<div class="col-lg-6">
						<label>Batch No.:</label>
						<select class="choose-batch" id="batch_add" style="width: 100%">
							<option></option>
							@foreach ($total as $item)
							<option>{{ $item->batch }}</option>
							@endforeach
							<option>New Batch</option>
						</select>
					</div>					

					<div class="col-lg-6">
						<label>Quantity:</label>
						<input type="text" id="quantity_add" class="form-control" required>
						<p class="errorQty text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

				<div class="row">
					<div class="form-group col-lg-12">
						<label>Remarks:</label>
						<select class="form-control" id="remarks_add">
							<option>New Batch</option>
							<option>Additional Count</option>
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

   <!-- EDIT MODAL -->
  <div class="modal fade" id="editInv" role="dialog">
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
						<select id="batch_edit" style="width: 100%">
							@foreach ($total as $item)
							<option>{{ $item->batch }}</option>
							@endforeach
						</select>
					</div>					

					<div class="col-lg-6">
						<label>Quantity:</label>
						<input type="text" id="quantity_edit" class="form-control" required>
						<p class="editQty text-center alert alert-danger hidden"></p>
					</div>
				
				</div>

				<br>

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
						<label class="hidden" id="editLabel">Remarks Description:</label>
						<textarea class="form-control hidden" id="remarks_edit1" rows="3" placeholder="Add any remarks to describe the action"></textarea>
						<p class="editRemarks text-center alert alert-danger hidden"></p>
					</div>
				</div>

				<input type="hidden" id="batchid">
				<input type="hidden" id="type">

	        </div>

	        <div class="modal-footer">
	        	<button type="button" class="btn btn-default edit-close" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info edit-this" data-dismiss="modal">Edit</button>
	        </div>

      </div>

@endsection

@section ('scripts')

<script>

	$(document).ready(function() {
	    $('.choose-batch').select2({
	    	placeholder: "Select batch",
	    	allowClear: true
	    });
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
            url: '/inventory/pullets/add',
            data: {
            	'batch_id': $('#batch_add').val(),
            	'quantity': $('#quantity_add').val(),
            	'remarks': $('#remarks_add').val() + '. ' + $('#remarks_add1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#addInv').modal('show');
            		$('.modal-footer').on('click', '.add-close', function () {
                        window.location.href = "/inventory/pullets";
                    });

            		if(data.errors.quantity) {
            			$('.errorQty').removeClass('hidden');
                        $('.errorQty').text(data.errors.quantity);
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
                        window.location.href = "/inventory/pullets";
                    });
            	}
            }
        });
    });

     $('.cancel-this').on('click', function() {
    	window.location.href = "/inventory/pullets";
    });

    // update quantity
    $('.update-this').on('click', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/pullets/update',
            data: {
            	'batch_id': $('#batch_choose').val(),
            	'quantity': $('#quantity_update').val(),
            	'remarks': $('#remarks_update').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('.cancel-this').on('click', function () {
                        window.location.href = "/inventory/pullets";
                    });

            		if(data.errors.quantity) {
            			$('.errorQty1').removeClass('hidden');
                        $('.errorQty1').text(data.errors.quantity);
            		}
            	}
            	
            	if ((data.error)) {
            		$('#errormsg').text(data.error);
	                $('#modalError').modal('show');
	                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/pullets";
                    });
            	}

            	else {

                $('#success').text('Successfully updated this item!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/pullets";
                    });
            	}
            }
        });
    });

    // edit item
    $(document).on('click', '.edit-modal', function() {
    	$('#batch_edit').val($(this).data('id'));
    	$('#batchid').val($(this).data('batchid'));
    	$('#quantity_edit').val($(this).data('quantity'));
    	$('#type').val($(this).data('type'));
        $('#editInv').modal('show');

    });

    $('#remarks_edit').change(function() {
		var option = $(this).find("option:selected").val();

		if (option == 'Others')
		{
			$('#remarks_edit1').removeClass('hidden');
			$('#editLabel').removeClass('hidden');
		}

		else
		{
			$('#remarks_edit1').addClass('hidden');
			$('#editLabel').addClass('hidden');
		}
	});

    $('.modal-footer').on('click', '.edit-this', function() {

    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

        $.ajax({
            type: 'POST',
            url: '/inventory/pullets/edit',
            data: {
            	'id': $('#batch_edit').val(),
            	'batch_id': $('#batchid').val(),
            	'quantity': $('#quantity_edit').val(),
            	'type': $('#type').val(),
            	'remarks': $('#remarks_edit').val() + '. ' + $('#remarks_edit1').val()
            },
            success: function(data) {
            	if ((data.errors)) {
            		$('#editInv').modal('show');
            		$('.modal-footer').on('click', '.edit-close', function () {
                        window.location.href = "/inventory/pullets";
                    });

            		if(data.errors.quantity) {
            			$('.editQty').removeClass('hidden');
                        $('.editQty').text(data.errors.quantity);
            		}

            		if(data.errors.remarks) {
            			$('.editRemarks').removeClass('hidden');
                        $('.editRemarks').text(data.errors.remarks);
            		}

            	}

            	else {

                $('#success').text('Successfully edited this entry!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/inventory/pullets";
                    });
            	}
            }
        });
    });

</script>

@endsection