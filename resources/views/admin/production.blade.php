@extends ('layout.admin-main')

@section ('title', 'Production')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')
	
<div class="row">


	<!-- Production Chart for Total Number of Eggs -->
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header" data-background-color="blue">
	            <h4 class="title">Total Number of Eggs</h4>
	            <!-- <p class="category">Here is a subtitle for this table</p> -->
	        </div>
	        <div class="card-content">
				<div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary bold">
                            <tr>
                                <th>Jumbo</th>
                                <th>Extra Large</th>
                                <th>Large</th>
                                <th>Medium</th>
                                <th>Small</th>
                                <th>Peewee</th>
                                <th>Soft-shell</th>
                           </tr>
                        </thead>
                        <tbody>

                            @if ($inv == null)
                            <tr>
                                <td colspan="7"><center><b>No items to show.</b></center></td>
                            </tr>

                            @else

                                <tr>
                                    <td>{{ $inv->total_jumbo }}</td>
                                    <td>{{ $inv->total_xlarge }}</td>
                                    <td>{{ $inv->total_large }}</td>
                                    <td>{{ $inv->total_medium }}</td>
                                    <td>{{ $inv->total_small }}</td>
                                    <td>{{ $inv->total_peewee }}</td>
                                    <td>{{ $inv->total_softshell }}</td>
                                </tr>

                            @endif
                            
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>

</div>

<div class="row">

	<div class="col-lg-12">
		<div class="card">
			<div class="card-header" data-background-color="blue">
	            <h4 class="title">Production Statistics</h4>
	        </div>
	        <div class="card-content">
				<canvas id="prodStats" width="400" height="150"></canvas>
	        </div>
		</div>
	</div>
    
</div>

@endsection

@section ('scripts')

<script>

$(document).ready(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        url: "/production/production-stats",
        method: "GET",
        success: function(data) {
            console.log(data);
            var batch = [];
            var total = [];

            for (var i in data) {
                batch.push('Batch ' + data[i].batch_id);
                total.push(data[i].jumbo + data[i].xlarge + data[i].large + data[i].medium + data[i].small + data[i].peewee);
            }

            var chartdata = {
                labels: batch,
                datasets : [
                    {
                        label: 'Number of Eggs',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.3)',
                        borderWidth: 1,
                        data: total
                    }
                ]
            };

            var ctx = $("#prodStats");

            var prodStats = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});

</script>

@endsection