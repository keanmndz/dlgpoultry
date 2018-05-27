@extends ('layout.admin-main')

@section ('title', 'Dashboard')

@section ('content')

@if ($user->access == 'Veterinarian')

<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <p class="category">Diagnosis</p>
                
                @if ($diagnosis == '' || $diagnosis == null)
                <h3 class="title">None</h3>
                @else
                <h3 class="title">{{ $diagnosis }}</h3>
                @endif

            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">info_outline</i> From last record.
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">assignment_turned_in</i>
            </div>
            <div class="card-content">
                <p class="category">Perscription</p>
                
                @if ($prescription == '' || $prescription == null)
                <h3 class="title">None</h3>
                @else
                <h3 class="title">{{ $prescription }}</h3>
                @endif

            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">info_outline</i> From last record.
                </div>
            </div>
        </div>
    </div>

</div>

@if ($acknowledge == 'done')

<div class="row">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="alert alert-success alert-with-icon" data-notify="container">
            <i data-notify="icon" class="material-icons">check_circle</i>
            <span data-notify="message">Management has administered the latest prescription and diagnosis.</span>
        </div>
    </div>

</div>

@elseif ($acknowledge == 'true')

<div class="row">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="alert alert-warning alert-with-icon" data-notify="container">
            <i data-notify="icon" class="material-icons">error</i>
            <span data-notify="message">Manager has acknowledged the latest prescription and diagnosis but has yet to administer the recommendations.</span>
        </div>
    </div>

</div>

@else

<div class="row">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="alert alert-danger alert-with-icon" data-notify="container">
            <i data-notify="icon" class="material-icons">help</i>
            <span data-notify="message">Manager has yet to read the latest update.</span>
        </div>
    </div>

</div>


@endif

<div class="row">

    <div class="col-lg-7">
        <div class="card">

            <div class="card-header" data-background-color="purple">
                <h4 class="title">Add a New Update</h4>
            </div>
            <div class="card-content">
                
                <!--  Error handle -->
                @if($errors->any())
                <div class="alert alert-warning">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="/vet/add" method="post">
    
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-lg-6 form-group label-floating">
                            <label class="control-label">Diagnosis</label>
                            <textarea id="diagnosis" name="diagnosis" class="form-control" rows="6"></textarea>
                        </div>
                        <div class="col-lg-6 form-group label-floating">
                            <label class="control-label">Prescription</label>
                            <textarea id="prescription" name="prescription" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group label-floating">
                            <label class="control-label">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pull-right col-lg-12">
                            <button class="btn btn-md btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Recent Activities on Chickens</h4>
            </div>
            <div class="card-content table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if ($chickens->isEmpty())
                        <tr>
                            <td colspan="4"><b><center>None to show.</center></b></td>
                        </tr>

                        @else

                        @foreach ($chickens as $item)
                            <tr>
                                <td>{{ $item->activity }}</td>
                                <td>{{ $item->remarks }}</td>
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

    <div class="col-md-12">
        <h4 class="text-center"><small>{{ $date }} - <i class="no-italics" id="time"></i></small></h4>

        <script type="text/javascript">
          function showTime() {
            var date = new Date(),
                utc = new Date(Date(
                  date.getFullYear(),
                  date.getMonth(),
                  date.getDate(),
                  date.getHours(),
                  date.getMinutes(),
                  date.getSeconds()
                ));

            document.getElementById('time').innerHTML = utc.toLocaleTimeString();
          }

          setInterval(showTime, 1000);
        </script>

    </div>

</div>

@else

<div class="row">
    <div class="col-md-12">
        <input type="button" class="btn btn-success btn-sm pull-right" value="View Poultry" name="DLG" id="dlgvideo" onclick="window.open('http://ezwp.tv/V7prbK2a', '_blank')"/>
    </div>
</div>

<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">content_paste</i>
            </div>
            <div class="card-content">
                <p class="category">Feeds</p>
                <h3 class="title">{{ $feeds }}
                    <small>sacks</small>
                </h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">info_outline</i> Check your inventory.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="no-italics material"><small>PHP</small></i>
            </div>
            <div class="card-content">
                <p class="category">Today's Sales</p>
	                <h3 class="title">
		
					@if ($sales == 0)
						0.00

					@else
		                {{ $sales }}
					
					@endif

	            	</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Within today.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="red">
                <i class="material-icons">error_outline</i>
            </div>
            <div class="card-content">
                <p class="category">Chicken Loss</p>
                <h3 class="title">{{ $dead }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">info_outline</i> Check population stats.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="purple">
                <i class="material-icons">group_add</i>
            </div>
            <div class="card-content">
                <p class="category">Customers</p>
                <h3 class="title">{{ $newcust }}</h3>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">update</i> Already updated.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Recent Orders</h4>
                <p class="category">{{ $date }}</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead class="text-primary">
                        <th>Order ID</th>
                        <th>Ordered By</th>
                        <th>Handled By</th>
                        <th>Purchase Cost</th>
                    </thead>
                    <tbody>
                    
                    @if ($orders->isEmpty())
                    <tr>
                        <td colspan="4"><center><b>No orders to show.</b></center></td>
                    </tr>

                    @else

                        @foreach ($orders as $order)

                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->cust_email }}</td>
                            <td>{{ $order->handled_by }}</td>
                            <td>{{ $order->total_cost }}</td>
                        </tr>

                        @endforeach

                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Recent Activity</h4>
                <p class="category">{{ $date }}</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead class="text-primary">
                        <th>User</th>
                        <th>Module</th>
                        <th>Activity</th>
                    </thead>
                    <tbody>
                    
                    @if ($act->isEmpty())
                    <tr>
                        <td colspan="4"><center><b>No activities to show.</b></center></td>
                    </tr>

                    @else

                        @foreach ($act as $acts)

                        <tr>
                            <td class="td-actions" rel="tooltip" title="{{ $acts->email }}">{{ $acts->user_id }}</td>
                            <td>{{ $acts->module }}</td>
                            <td>{{ $acts->activity }}</td>
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

    <div class="col-md-12">
        <h4 class="text-center"><small>{{ $date }} - <i class="no-italics" id="time"></i></small></h4>

        <script type="text/javascript">
          function showTime() {
            var date = new Date(),
                utc = new Date(Date(
                  date.getFullYear(),
                  date.getMonth(),
                  date.getDate(),
                  date.getHours(),
                  date.getMinutes(),
                  date.getSeconds()
                ));

            document.getElementById('time').innerHTML = utc.toLocaleTimeString();
          }

          setInterval(showTime, 1000);
        </script>

    </div>

</div>

@endif

@endsection
