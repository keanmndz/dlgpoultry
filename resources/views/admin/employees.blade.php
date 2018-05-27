@extends ('layout.admin-main')

@section ('title', 'Employees')

@section ('content')

<div class="row">

	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Employees</h4>
	            <!-- <p class="category">SUBTITLE</p> -->
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Position</th>
							<th>Contact Number</th>
							<th>Username</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					
					@foreach ($emp as $emps)

						<tr>
							<td>{{ $emps->id }}</td>
							<td>{{ $emps->lname }}, {{ $emps->fname }}</td>
							@if ($emps->access == 'SysAdmin')
							<td>System Administrator</td>
							@else
							<td>{{ $emps->access }}</td>
							@endif
							<td>{{ $emps->mobile }}</td>
							<td>{{ $emps->username }}</td>
							<td class="td-actions text-right">
								<button type="button" rel="tooltip" title="View Info" class="btn btn-info btn-simple btn-xs">
                                    <i class="material-icons">info_outline</i>
                                </button>
                                <button type="button" rel="tooltip" title="Edit" class="btn btn-warning btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-simple btn-xs">
                                    <i class="material-icons">delete</i>
                                </button>
                            </td>
						</tr>
					@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

@endsection