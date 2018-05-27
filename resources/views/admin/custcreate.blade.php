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

		<form action="/customers/add" method="post">
			<center><legend><h3>Create New Customer</h3></legend></center>
			
			{{ csrf_field() }}

			<!-- Last Name -->
			<div class="form-group">
				<b>Last Name</b>
				<input class="form-control" type="text" name="lname" value="{{ old('lname') }}" autofocus required>
			</div>

			<!-- First Name -->
			<div class="form-group">
				<b>First Name</b>
				<input class="form-control" type="text" name="fname" value="{{ old('fname') }}" required>
			</div>

			<!-- Middle Name -->
			<div class="form-group">
				<b>Middle Name</b>
				<input class="form-control" type="text" name="mname" value="{{ old('mname') }}" required>
			</div>

			<!-- Company -->
			<div class="form-group">
				<b>Company Name</b>
				<input class="form-control" type="text" name="company" value="{{ old('company') }}" required>
			</div>

			<!-- Email Address -->
			<div class="form-group">
				<b>Email Address</b>
				<input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
			</div>

			<!-- Address -->
			<div class="form-group">
				<b>Address</b>
				<input class="form-control" type="text" name="address" value="{{ old('address') }}" required>
			</div>

			<!-- Contact -->
			<div class="form-group">
				<b>Contact Number</b>
				<input class="form-control" type="text" name="contact" value="{{ old('contact') }}" required>
			</div>

			<!-- Button -->	
			<center><div class="form-group">
				<center>Password will be sent to the given email upon submit.</center>
				<button type="submit" class="btn btn-md btn-info">Add Customer</button>	
			</div></center>
		</form>

	</div>

</div>


@endsection