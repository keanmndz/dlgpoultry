@extends ('layout.admin-main')

@section ('title', 'Population')

@section ('token')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section ('content')

<form action="/population/pdf" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <button type="button" title="Report" class="btn btn-md btn-info" onclick="window.open('/population/pdf', '_blank')">Generate Report</button>
</form>

<div class="row">

	<!-- Population Chart for Number of Alive, Dead, and Cull for the day -->
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header" data-background-color="blue">
	            <h4 class="title">Current Chicken Population</h4>
	            <!-- <p class="category">Here is a subtitle for this table</p> -->
	        </div>
	        <div class="card-content">
				<canvas id="popStats" width="400" height="150"></canvas>
                <br>
			</div>
		</div>
	</div>

</div>

<div class="row">

    <!-- Population Chart for Number of Dead and Cull for the day -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Total Cull</h4>
                <!-- <p class="category">Here is a subtitle for this table</p> -->
            </div>
            <div class="card-content">
                <canvas id="popCull" width="400" height="150"></canvas>
                <br>
                <form action="/population/pdf" method="post">
            </div>
        </div>
    </div>

</div>

<div class="row">

    <!-- Population Chart for Number of Dead and Cull for the day -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Chicken Mortality</h4>
                <!-- <p class="category">Here is a subtitle for this table</p> -->
            </div>
            <div class="card-content">
                <canvas id="popDead" width="400" height="150"></canvas>
                <br>
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
        url: "/population/population-stats",
        method: "GET",
        success: function(data) {
            console.log(data);
            var batch = [];
            var total = [];

            for (var i in data) {
                batch.push('Batch ' + data[i].batch);
                total.push(data[i].quantity);
            }

            var chartdata = {
                labels: batch,
                datasets : [
                    {
                        label: 'Number of Chickens',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.3)',
                        borderWidth: 1,
                        data: total
                    }
                ]
            };

            var ctx = $("#popStats");

            var popStats = new Chart(ctx, {
                type: 'bar',
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

    $.ajax({
        url: "/population/cull-stats",
        method: "GET",
        success: function(data) {
            console.log(data);
            var batch = [];
            var total = [];

            for (var i in data) {
                batch.push('Batch ' + data[i].batch_id);
                total.push(data[i].quantity);
            }

            var chartdata = {
                labels: batch,
                datasets : [
                    {
                        label: 'Number of Cull',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.3)',
                        borderWidth: 1,
                        data: total
                    }
                ]
            };

            var ctx = $("#popCull");

            var prodCull = new Chart(ctx, {
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

    $.ajax({
        url: "/population/dead-stats",
        method: "GET",
        success: function(data) {
            console.log(data);
            var batch = [];
            var total = [];

            for (var i in data) {
                batch.push(data[i].created_at);
                total.push(data[i].quantity);
            }

            var chartdata = {
                labels: batch,
                datasets : [
                    {
                        label: 'Mortality',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.3)',
                        borderWidth: 1,
                        data: total
                    }
                ]
            };

            var ctx = $("#popDead");

            var prodCull = new Chart(ctx, {
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