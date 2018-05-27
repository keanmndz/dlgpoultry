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

		<form action="{{ $user->id }}/insert" method="post">

			<center><legend><h3>Update Your Information</h3></legend></center>

		{{ csrf_field() }}

			<div class="form-group">

				<b>First Name</b>
				<input type="text" class="form-control" name="fname" id="fname" placeholder="John" value="{{ $user->fname }}" required autofocus>
			</div>

			<div class="form-group">
				<b>Last Name</b>
				<input type="text" class="form-control" name="lname" id="lname" placeholder="Smith" value="{{ $user->lname }}" required>
			</div>

			<div class="form-group">
				<b>Mobile Number</b>
				<input type="text" class="form-control" name="mobile" id="mobile" placeholder="09xx xxx xxxx" value="{{ $user->mobile }}" required>
			</div>

			<div class="form-group">
				<b>Email Address</b>
				<input type="email" class="form-control" name="email" id="email" placeholder="you@mail.com" value="{{ $user->email }}" required>
			</div>

			<div class="form-group">
				<b>Address</b>
				<input type="text" class="form-control" name="address" id="address" placeholder="City" value="{{ $user->address }}" required>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-md btn-info">Submit</button>
			</div>
		</form>

	</div>

</div>

@endsection
