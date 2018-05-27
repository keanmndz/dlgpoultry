@extends ('layout.admin-main')

@section ('title', 'User Panel')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<div class="row">

	<div class="col-lg-6">

		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Settings and Actions</h4>
	            <!-- <p class="category">Here is a subtitle for this table</p> -->
	        </div>
	        <div class="card-content table-responsive">
				@if($user->access == 'Manager' || $user->access == 'SysAdmin')
					<b>User Accounts</b>
					<hr class="break">
					<button class="btn btn-md btn-info" onclick="window.location.href='create'">Add User</button>&ensp;
					<button class="btn btn-md btn-warning" onclick="window.location.href='archives'">User Archives</button>&ensp;
					<br><br>
				@endif
				<b>Your Account</b>
				<hr class="break">
				<button class="btn btn-md btn-info" onclick="window.location.href='edit/{{ $user->id }}'">Edit Your Details</button>&ensp;
				<button class="btn btn-md btn-info change-this" data-id="{{ $user->id }}" data-pass="{{ $user->password }}">Change Your Password</button>&ensp;
				<br>
				<button class="btn btn-sm btn-default disable" data-id="{{ $user->id }}">Disable your Account</button>

			</div>
		</div>

	</div>

	<div class="col-lg-6">

		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Your User Details</h4>
	            <!-- <p class="category">Here is a subtitle for this table</p> -->
	        </div>
	        <div class="card-content table-responsive">

				<b>Full Name</b>: {{ $user->fname }} {{ $user->lname }}
				<hr class="break">
				<b>Email Address</b>: {{ $user->email }}
				<hr class="break">
				<b>Mobile Number</b>: {{ $user->mobile }}
				<hr class="break">
				<b>Address</b>: {{ $user->address }}
				<hr class="break">
				<b>Access</b>:
				@if($user->access == 'SysAdmin')
					System Administrator
				@else
					{{ $user->access }}
				@endif
			</div>
		</div>

	</div>

</div>

@if ($user->access == 'Farm Hand')

<div class="row">

	<div class="col-lg-12 container-fluid">
		<div class="card">
	        <div class="card-header" data-background-color="green">
	            <h4 class="title">Veterinarian Updates</h4>
	            <p class="category">Updates on poultry health.</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>From</th>
							<th>Diagnosis</th>
							<th>Prescription</th>
							<th>Notes</th>
							<th>Status</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					
					@if ($vet->isEmpty())
						<tr>
							<td colspan="7"><b><center>Nothing to show.</center></b></td>
						</tr>

					@else
						@foreach ($vet as $item)
							
							@if ($item->acknowledge == 'true')
							<tr>
								<td>From: <b>{{ $item->fname }} {{ $item->lname }}</b></td>
								<td><b>{{ $item->diagnosis }}</b></td>
								<td>{{ $item->prescription }}</td>
								<td>{{ $item->notes }}</td>
								<td>{{ $item->created_at }}</td>
								@if ($item->acknowledge == 'done')
								<td class="text-success">Administered</td>
								<td class="td-actions text-right">
								
									<button type="button" rel="tooltip" title="Approve" class="btn btn-success btn-simple btn-xs" onclick="window.location.href='/vet/acknowledge/{{ $item->id }}'" disabled>
										<i class="material-icons">check</i>
									</button>
								
								</td>
								@else
								<td class="text-warning">Acknowledged</td>
								<td class="td-actions text-right">
								
									<button type="button" rel="tooltip" title="Administer" class="btn btn-success btn-simple btn-xs" onclick="window.location.href='/vet/administer/{{ $item->id }}'">
										<i class="material-icons">check</i>
									</button>
								
								</td>
								@endif
							@endif
								
							</tr>
							<br>
						@endforeach
					@endif

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

@elseif ($user->access == 'Veterinarian')

<div class="row">

	<div class="col-lg-12 container-fluid">
		<div class="card">
	        <div class="card-header" data-background-color="green">
	            <h4 class="title">Veterinarian Updates</h4>
	            <p class="category">Updates on poultry health.</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table">
					<thead class="text-primary bold">
						<tr>
							<th>From</th>
							<th>Diagnosis</th>
							<th>Prescription</th>
							<th>Notes</th>
							<th>Status</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
					
					@if ($vet->isEmpty())
						<tr>
							<td colspan="6"><b><center>Nothing to show.</center></b></td>
						</tr>

					@else
						@foreach ($vet as $item)
							
							<tr>
								<td>From: <b>{{ $item->fname }} {{ $item->lname }}</b></td>
								<td><b>{{ $item->diagnosis }}</b></td>
								<td>{{ $item->prescription }}</td>
								<td>{{ $item->notes }}</td>
								<td>{{ $item->created_at }}</td>
								@if ($item->acknowledge == 'done')
								<td class="text-success">Administered</td>
								@elseif ($item->acknowledge == 'true')
								<td class="text-warning">Acknowledged</td>
								@else
								<td class="text-danger">Pending</td>
								@endif
							</tr>
							<br>
						@endforeach
					@endif

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>


@elseif ($user->access == 'Manager' || $user->access == 'SysAdmin')

<div class="row">

	<div class="col-lg-12 container-fluid">

		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#accounts"><i class="material-icons">group</i> Employee Accounts</a></li>
			<li><a data-toggle="tab" href="#approvals"><i class="material-icons">assignment_turned_in</i> Action Approvals</a></li>
			<li><a data-toggle="tab" href="#history"><i class="material-icons">assignment_ind</i> Approvals History</a></li>
			<li><a data-toggle="tab" href="#vet"><i class="material-icons">assessment</i> Veterinarian Updates</a></li>
		</ul>

		<div class="tab-content">
			
			<div id="accounts" class="tab-pane fade in active">
				<br>
				<div class="card">
			        <div class="card-header" data-background-color="green">
			            <h4 class="title">Employee Accounts</h4>
			            <p class="category">Manage employee information.</p>
			        </div>
			        <div class="card-content table-responsive">
						
						<div class="col-lg-4">
			        		<select class="form-control" id="chooseFilter">
			        			<option value="0">Name</option>
			        			<option value="1">Email Address</option>
			        			<option value="2">Access</option>
			        		</select>
			        	</div>
			        	<div class="col-lg-8">
		                    <input type="text" class="form-control" id="userInput" onkeyup="userSearch()" placeholder="Search...">
		                </div>

						<table class="table" id="tblUsers">
							<thead class="text-primary bold">
								<tr>
									<th>Full Name</th>
									<th>Email Address</th>
									<th>Access</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@foreach ($allusers as $all)
								<tr>
									<td>{{ $all->lname }}, {{ $all->fname }}</td>
									<td>{{ $all->email }}</td>

									@if ($all->access == 'SysAdmin')
									<td>System Administrator</td>
									@else
									<td>{{ $all->access }}</td>
									@endif
									<td class="td-actions text-right">
										 @if ($all->email == Auth::user()->email)
		                                <button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs" disabled>
		                                    <i class="material-icons">edit</i>
		                                </button>
		                                <button type="button" rel="tooltip" title="Disable" class="btn btn-danger btn-simple btn-xs delete-modal" disabled>
		                                    <i class="material-icons">remove_circle_outline</i>
		                                </button>
		                            </td>
		                            	@else
		                                <button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs">
		                                    <i class="material-icons">edit</i>
		                                </button>
		                                <button type="button" rel="tooltip" title="Disable" class="btn btn-danger btn-simple btn-xs delete-modal" data-id="{{ $all->id }}" data-name="{{ $all->fname }} {{ $all->lname }}" data-email="{{ $all->email }}" data-access="{{ $all->access }}">
		                                    <i class="material-icons">remove_circle_outline</i>
		                                </button>
		                            </td>
		                            @endif
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
				</div>
			</div>
		

			<div id="approvals" class="tab-pane fade">
				<br>
				<div class="card">
			        <div class="card-header" data-background-color="green">
			            <h4 class="title">Action Approvals</h4>
			            <p class="category">Actions from farm hand accounts which are for approval.</p>
			        </div>
			        <div class="card-content table-responsive">

						<table class="table">
							<thead class="text-primary bold">
								<tr>
									<th>Email Address</th>
									<th>Action Made</th>
									<th>Module</th>
									<th>User Remarks</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							@if ($approvals->isEmpty())
								<tr>
									<td colspan="6"><b><center>Nothing for approval.</center></b></td>
								</tr>

							@else
								@foreach ($approvals as $item)

									<tr>
										<td>{{ $item->email }}</td>
										<td>{{ $item->action }}</td>
										<td>{{ $item->module }}</td>
										<td>{{ $item->remarks }}</td>
										<td>{{ $item->status }}</td>
										<td class="td-actions text-right">
										
											<button type="button" rel="tooltip" title="Approve" class="btn btn-success btn-simple btn-xs" onclick="window.location.href='/approvals/approve/{{ $item->id }}'">
												<i class="material-icons">check</i>
											</button>
											<button type="button" rel="tooltip" title="Disapprove" class="btn btn-danger btn-simple btn-xs" onclick="window.location.href='/approvals/disapprove/{{ $item->id }}'">
												<i class="material-icons">clear</i>
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

			<div id="history" class="tab-pane fade">
				<br>
				<div class="card">
			        <div class="card-header" data-background-color="green">
			            <h4 class="title">Approvals History</h4>
			            <p class="category">History of approved and disapproved actions from farm hand.</p>
			        </div>
			        <div class="card-content table-responsive">
						
						<div class="col-lg-4">
			        		<select class="form-control" id="chooseFilter1">
			        			<option value="0">Email Address</option>
			        			<option value="1">Action Made</option>
			        			<option value="2">Module</option>
			        		</select>
			        	</div>
			        	<div class="col-lg-8">
		                    <input type="text" class="form-control" id="historyInput" onkeyup="historySearch()" placeholder="Search...">
		                </div>

						<table class="table" id="tblHistory">
							<thead class="text-primary bold">
								<tr>
									<th>Email Address</th>
									<th>Action Made</th>
									<th>Module</th>
									<th>User Remarks</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							
							@if ($history->isEmpty())
								<tr>
									<td colspan="6"><b><center>Nothing to show.</center></b></td>
								</tr>

							@else
								@foreach ($history as $item)

									<tr>
										<td>{{ $item->email }}</td>
										<td>{{ $item->action }}</td>
										<td>{{ $item->module }}</td>
										<td>{{ $item->remarks }}</td>
										<td>{{ $item->status }}</td>
									</tr>

								@endforeach
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div id="vet" class="tab-pane fade">
				<br>
				<div class="card">
			        <div class="card-header" data-background-color="green">
			            <h4 class="title">Veterinarian Updates</h4>
			            <p class="category">Updates on poultry health.</p>
			        </div>
			        <div class="card-content table-responsive">
						<table class="table">
							<thead class="text-primary bold">
								<tr>
									<th>From</th>
									<th>Diagnosis</th>
									<th>Prescription</th>
									<th>Notes</th>
									<th>Status</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							@if ($vet->isEmpty())
								<tr>
									<td colspan="6"><b><center>Nothing to show.</center></b></td>
								</tr>

							@else
								@foreach ($vet as $item)

									<tr>
										<td>From: <b>{{ $item->fname }} {{ $item->lname }}</b></td>
										<td><b>{{ $item->diagnosis }}</b></td>
										<td>{{ $item->prescription }}</td>
										<td>{{ $item->notes }}</td>
										<td>{{ $item->created_at }}</td>
										@if ($item->acknowledge == 'true')
										<td class="text-warning">Acknowledged</td>
										<td class="td-actions text-right">
										
											<button type="button" rel="tooltip" title="Approve" class="btn btn-success btn-simple btn-xs" disabled>
												<i class="material-icons">check</i>
											</button>
										
										</td>
										@elseif ($item->acknowledge == 'done')
										<td class="text-success">Administered</td>
										<td class="td-actions text-right">
										
											<button type="button" rel="tooltip" title="Approve" class="btn btn-success btn-simple btn-xs" disabled>
												<i class="material-icons">check</i>
											</button>
										
										</td>
										@else
										<td class="text-danger">Pending</td>
										<td class="td-actions text-right">
										
											<button type="button" rel="tooltip" title="Approve" class="btn btn-success btn-simple btn-xs" onclick="window.location.href='/vet/acknowledge/{{ $item->id }}'">
												<i class="material-icons">check</i>
											</button>
										
										</td>
										@endif
										
									</tr>
									<br>
								@endforeach
							@endif

							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>    
	    
	</div>

</div>

@endif

<!-- MODALS -->

<!-- Delete -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete</h3>
            </div>
            <div class="modal-body">
                <br>
                <h4>Are you sure to disable this employee's data and access?</h4>
                <br>
                <input type="hidden" id="id_delete">
				<table class="table table-responsive table-hover">
					<tr>
						<th>Full Name:</th>
						<td id="name_delete"></td>
					</tr>
					<tr>
						<th>Email Address:</th>
						<td id="email_delete"></td>
					</tr>
					<tr>
						<th>Access:</th>
						<td id="access_delete"></td>
					</tr>
				</table>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-danger delete" data-dismiss="modal">Disable</button>
	            </div>
            </div>
        </div>
    </div>
</div>

<!-- Disable Your Account -->
<div id="disableThis" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Disable Your Account</h3>
            </div>
            <div class="modal-body">
                <br>
                <h4>Are you sure to disable your own account?</h4>
                <p>This action will end your session and archive your account. Please review this action before confirming.</p>
                <hr class="br-2">
                <p>You may contact the System Administrator to recover your account after disabling.</p>
                <br>
                <input type="hidden" id="id_this">

	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-danger disable-this" data-dismiss="modal">Confirm</button>
	            </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password -->
<div id="changePass" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Change Password</h3>
            </div>
            <div class="modal-body">
                <br>
                <h4>Enter a new password.</h4>
                <br>
               		 <input type="hidden" id="id_change">
					 
					 <label for="pass">New Password: </label>
					 <input type="password" class="form-control" id="pass" placeholder="Your new password." required>
					 <p class="errorPass text-center alert alert-danger hidden"></p>
					 <br>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-default close-change" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-success change-pass" data-dismiss="modal">Confirm</button>
	            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section ('scripts')

<script>

    // delete
    $(document).on('click', '.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#id_delete').val($(this).data('id'));
        $('#name_delete').text($(this).data('name'));
        $('#email_delete').text($(this).data('email'));
        $('#access_delete').text($(this).data('access'));
        $('#deleteModal').modal('show');
        id = $('#id_delete').val();
    });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'GET',
            url: '/admin/' + id + '/delete',
            success: function(data) {
                $('#success').text('Successfully disabled this user!');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/admin/details";
                    });
            }
        });
    });

    // disable your account
    $(document).on('click', '.disable', function() {
        $('#id_this').val($(this).data('id'));
        $('#disableThis').modal('show');
        id = $('#id_this').val();
    });

    $('.modal-footer').on('click', '.disable-this', function() {
        $.ajax({
            type: 'GET',
            url: '/admin/' + id + '/delete',
            success: function(data) {
                $('#success').text('Disabled your account! Now ending your session...');
                $('#myModal2').modal('show');
                $('.modal-footer').on('click', '.close-this', function () {
                        window.location.href = "/";
                    });
            }
        });
    });

	 // change password
	 $(document).on('click', '.change-this', function() {
			$('#id_change').val($(this).data('id'));
			$('#changePass').modal('show');
			id = $('#id_change').val();
	  });

	 $('.modal-footer').on('click', '.change-pass', function() {
	    	$.ajaxSetup({
		      headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		      }
		    });    

	        $.ajax({
	            type: 'POST',
	            url: '/admin/edit/' + id + '/pass',
	            data: {
	            	'id': $('#id_change').val(),
					'password': $('#pass').val()
	            },
	            success: function(data) {
	            	if ((data.errors)) {
	            		$('#changePass').modal('show');
	            		$('.modal-footer').on('click', '.close-change', function () {
	                        window.location.href = "/admin/details";
	                    });

	            		if(data.errors.password) {
	            			$('.errorPass').removeClass('hidden');
	                        $('.errorPass').text(data.errors.password);
	            		}
	            	}

	            	if ((data.error))
		            {
		                $('#errormsg').text(data.error);
		                $('#modalError').modal('show');
		                $('.modal-footer').on('click', '.close-this', function () {
		                    window.location.href = "/admin/details";
		                });
		            }

	            	else {
	                $('#success').text('Successfully changed your password!');
	                $('#myModal2').modal('show');
	                $('.modal-footer').on('click', '.close-this', function () {
	                        window.location.href = "/admin/details";
	                    });
	            	}
	        	}
	   	 	});

		});

	function userSearch() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  var choose = $('#chooseFilter').val();
	  input = document.getElementById("userInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tblUsers");
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

	function historySearch() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  var choose = $('#chooseFilter1').val();
	  input = document.getElementById("historyInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tblHistory");
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
