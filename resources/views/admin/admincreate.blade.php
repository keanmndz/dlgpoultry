@extends ('layout.admin-main')

@section ('title', 'User Panel')

@section ('content')

<button class="btn btn-md btn-simple" onclick="window.location.href='{{ URL('admin/details') }}'"><i class="material-icons">keyboard_arrow_left</i>&ensp;User Details</button>

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

		<form action="new" method="post">

			<center><legend><h3>Create New User</h3></legend></center>

		{{ csrf_field() }}

			<div class="form-group">

				<b>First Name</b>
				<input type="text" class="form-control" name="fname" id="fname" placeholder="John" value="{{ old('fname') }}" required autofocus>
			</div>

			<div class="form-group">
				<b>Last Name</b>
				<input type="text" class="form-control" name="lname" id="lname" placeholder="Smith" value="{{ old('lname') }}" required>
			</div>

			<div class="form-group">
				<b>Email Address</b>
				<input type="email" class="form-control" name="email" id="email" placeholder="johnsmith@email.com" value="{{ old('email') }}" required>
			</div>

			<div class="form-group">
				<b>Mobile Number</b>
				<input type="text" class="form-control" name="mobile" id="mobile" placeholder="09xx xxx xxxx" value="{{ old('mobile') }}" required>
			</div>

			<div class="form-group">
				<b>Address</b>
				<input type="text" class="form-control" name="address" id="address" placeholder="City" value="{{ old('address') }}" required>
			</div>

			<div class="form-group">
				<b>Access</b>
				<select class="form-control" name="access" id="access" value="{{ old('access') }}">
					<option value="Farm Hand">Farm Hand</option>
					@if ($user->access != 'SysAdmin')
				</select>
					@else
					<option value="Manager">Manager</option>
					<option value="SysAdmin">System Administrator</option>
				</select>
					@endif
			</div>

			<center><div class="form-group">
					<center>Password will be randomly generated and sent to the given email upon submit.</center>
					<button type="submit" class="btn btn-md btn-info">Submit</button>
			</div></center>
		</form>

	</div>

</div>

@endsection
