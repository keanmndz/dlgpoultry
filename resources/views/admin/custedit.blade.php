@extends ('layout.admin-main')

@section ('title', 'Customers')

@section ('content')

<button type="button" class="btn btn-md btn-simple" onclick="window.location.href='/customers'"><i class="material-icons">keyboard_arrow_left</i>&ensp; Customers</button>

<div class="row">

	<div class="col-lg-12">

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

		<form action="/customers/{{ $customers[0]->id }}/update" method="post">

			<center><legend><h3>Update Customer Details</h3></legend></center>
				
				{{ csrf_field() }}

			<!-- Last Name -->
			<div class="form-group">
				Last Name: <input class="form-control" type="text" name="lname" value="{{ $customers[0]->lname }}" required autofocus>
			</div>

			<!-- First Name -->
			<div class="form-group">
				First Name: <input class="form-control" type="text" name="fname" value="{{ $customers[0]->fname }}" required>
			</div>

			<!-- Middle Name -->
			<div class="form-group">
				Middle Name: <input class="form-control" type="text" name="mname" value="{{ $customers[0]->mname }}" required>
			</div>

			<!-- Company -->
			<div class="form-group">
				Company Name: <input class="form-control" type="text" name="company" value="{{ $customers[0]->company }}" required>
			</div>

			<!-- Address -->
			<div class="form-group">
				Address: <input class="form-control" type="text" name="address" value="{{ $customers[0]->address }}" required>
			</div>

			<!-- Contact -->
			<div class="form-group">
				Contact Number: <input class="form-control" type="text" name="contact" value="{{ $customers[0]->contact }}" required>
			</div>

				<!-- Button -->	
				<center><div class="form-group">
					<button type="submit" class="btn btn-md btn-info">Update Customer</button>
				</div></center>

			</form>
</div>

@endsection