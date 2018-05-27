@extends ('layout.admin-main')

@section ('title', 'User Panel > Archives')

@section ('content')

<button type="button" class="btn btn-md btn-simple" onclick="window.location.href='/admin/details'"><i class="material-icons">keyboard_arrow_left</i>&ensp; User Panel</button>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
	        <div class="card-header" data-background-color="blue">
	            <h4 class="title">User Archives</h4>
<!-- 	            <p class="category">Subtitle</p> -->
	        </div>
	        <div class="card-content table-responsive">
				<table class="table table-hover">
					<thead class="text-primary bold">
						<tr>
							<th>User ID</th>
							<th>Full Name</th>
                            <th>Email Address</th>
							<th>Access</th>
							<th>Disabled By</th>
                            <th>Remember Token</th>
                            <th>Status</th>
                        </tr>
					</thead>
					<tbody>

                    @if ($arc->isEmpty())
                    <tr>
                        <td colspan="7"><center><b>No users to show.</b></center></td>
                    </tr>
                    
                    @else

    					@foreach ($arc as $arcs)

    					<tr>
    						<td>{{ $arcs->user_id }}</td>
    						<td>{{ $arcs->lname }}, {{ $arcs->fname }}</td>
                            <td>{{ $arcs->email }}</td>
    						<td>{{ $arcs->access }}</td>
    						<td>{{ $arcs->disabled_by }}</td>
                            <td>{{ $arcs->remember_token }}</td>
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