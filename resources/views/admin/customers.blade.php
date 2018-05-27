@extends ('layout.admin-main')

@section ('title', 'Customers')

@section ('content')

<div class="row">
	<div class="col-lg-8">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">New Customers</h4>
	            <p class="category">Within 7 days from today</p>
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Customer ID</th>
							<th>Full Name</th>
                            <th>Email Address</th>
							<th>Company Name</th>
							<th>Date Created</th>
                        </tr>
					</thead>
					<tbody>

                    @if ($newcust->isEmpty())
                    <tr>
                        <td colspan="6"><center><b>No customers to show.</b></center></td>
                    </tr>
                    
                    @else

    					@foreach ($newcust as $newcusts)

    					<tr>
    						<td>{{ $newcusts->id }}</td>
    						<td>{{ $newcusts->lname }}, {{ $newcusts->fname }}</td>
                            <td>{{ $newcusts->email }}</td>
    						<td>{{ $newcusts->company }}</td>
    						<td>{{ $newcusts->created_at }}</td>
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
                    <li class="list-group-item action-tab" onclick="window.location.href='customers/create'"><b>Create New Customer</b></li>
                    <li class="list-group-item action-tab" onclick="window.location.href='customers/archives'"><b>View Customer Archives</b></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">All Customers</h4>
	        </div>
	        <div class="card-content table-responsive">
                
                <div class="row">
                    <div class="col-lg-2">
                        <select class="form-control" id="chooseFilter">
                            <option value="0">Customer ID</option>
                            <option value="1">Full Name</option>
                            <option value="2">Email Address</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search...">
                    </div>
                </div>
				
                <table id="myTable" class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>Customer ID</th>
							<th>Full Name</th>
                            <th>Email Address</th>
							<th>Company Name</th>
							<th>Address</th>
							<th>Contact Number</th>
							<th>Actions</th></tr>
					</thead>
					<tbody>

                        @if ($customers->isEmpty())
                        <tr>
                            <td colspan="6"><center><b>No customers to show.</b></center></td>
                        </tr>

                        @else

        					@foreach ($customers as $customer)

        					<tr class="item{{ $customer->id }}">
        						<td>{{ $customer->id}}</td>
        						<td>{{ $customer->lname }}, {{ $customer->fname }}</td>
                                <td>{{ $customer->email }}</td>
        						<td>{{ $customer->company }}</td>
        						<td>{{ $customer->address }}</td>
        						<td>{{ $customer->contact }}</td>
        						<td class="td-actions text-right">
                                <button type="button" rel="tooltip" title="Update" class="btn btn-warning btn-simple btn-xs" onclick="window.location.href='/customers/{{ $customer->id }}/edit'">
                                    <i class="material-icons">update</i>
                                </button>
                                <button type="button" rel="tooltip" title="Disable" class="delete-modal btn btn-danger btn-simple btn-xs" data-id="{{ $customer->id }}" data-name="{{ $customer->fname }} {{ $customer->lname }}"">
                                    <i class="material-icons">remove_circle_outline</i>
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
                <h4 class="title">Activity Log</h4>
            </div>
            <div class="card-content table-responsive">
                
                <table class="table table-hover">
                    <thead class="text-primary bold">
                        <tr>
                            <th>Activity ID</th>
                            <th>Activity</th>
                            <th>Email Address</th>
                            <th>Remarks</th>
                            <th>Done By</th>
                            <th>Date and Time</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($activity->isEmpty())
                        <tr>
                            <td colspan="6"><center><b>No activities to show.</b></center></td>
                        </tr>

                        @else

                            @foreach ($activity as $act)

                            <tr class="item{{ $customer->id }}">
                                <td>{{ $act->id }}</td>
                                <td>{{ $act->activity }}</td>
                                <td>{{ $act->cust_email }}</td>
                                <td>{{ $act->remarks }}</td>
                                <td>{{ $act->user }}</td>
                                <td>{{ $act->changed_at }}</td>
                            </tr>

                            @endforeach

                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- MODALS -->

<!-- Delete -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Disable</h3>
            </div>
            <div class="modal-body">
                <br>
                <h4 class="text-center">Are you sure you want to disable the following customer?</h4>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_delete" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="name_delete" disabled>
                        </div>
                    </div>
                </form>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete" data-dismiss="modal">Disable</button>
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
            $('#name_delete').val($(this).data('name'));
            $('#deleteModal').modal('show');
            id = $('#id_delete').val();
        });

        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'GET',
                url: '/customers/' + id + '/delete',
                success: function(data) {
                    $('#success').text('Successfully disabled this customer!');
                    $('#myModal2').modal('show');
                    $('.modal-footer').on('click', '.close-this', function () {
                            window.location.href = "/customers";
                        });
                }
            });
        });

        function myFunction() {
          // Declare variables 
          var input, filter, table, tr, td, i;
          var choose = $('#chooseFilter').val();
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
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
