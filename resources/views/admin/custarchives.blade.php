@extends ('layout.admin-main')

@section ('title', 'Customers > Archives')

@section ('content')

<button type="button" class="btn btn-md btn-simple" onclick="window.location.href='/customers'"><i class="material-icons">keyboard_arrow_left</i>&ensp; Customers</button>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">Customer Archives</h4>
<!-- 	            <p class="category">Subtitle</p> -->
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>User ID</th>
							<th>Full Name</th>
                            <th>Email Address</th>
							<th>Company</th>
                            <th>Contact Number</th>
							<th>Disabled By</th>
                            <th>Status</th>
                        </tr>
					</thead>
					<tbody>

                    @if ($arc->isEmpty())
                    <tr>
                        <td colspan="7"><center><b>No customers to show.</b></center></td>
                    </tr>
                    
                    @else

    					@foreach ($arc as $arcs)

    					<tr>
    						<td>{{ $arcs->cust_id }}</td>
    						<td>{{ $arcs->lname }}, {{ $arcs->fname }}</td>
                            <td>{{ $arcs->email }}</td>
    						<td>{{ $arcs->company }}</td>
                            <td>{{ $arcs->contact }}</td>
    						<td>{{ $arcs->disabled_by }}</td>
                            <td>{{ $arcs->status }}</td>
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