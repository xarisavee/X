@extends('layouts.dashlayout')

@section('content')       
<!-- <section id="advertisement">
    <div class="container">
        <img src="{{asset('images/shop/advertisement.jpg')}}" alt="" />
    </div>
</section> -->

<section>
    <div id="wrapper">
         @include('shared.sidebar')  

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Add New User</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<form name="addtut" action="tutors.php?action=savingnewtutor" method="post">
							<div class="panel-heading">
								User Information
							</div>
							<div class="panel-body">
								<div class="col-lg-6 col-lg-offset-0">
									<div class="col-lg-6 form-group text-center">
										<img id="preview" src="images/avatar.jpeg" alt="Image Preview"/>
										<input id="fileToUpload" name="fileToUpload" type="file" onchange="loadImageFile();" accept="image/gif, image/jpeg, image/jpg, image/png">
									</div>
								</div>
								<div class="col-lg-12 col-lg-offset-0">
										<label>ID Number</label>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<input id="admin_id" name="admin_id" class="form-control" placeholder="ID Number" required maxlength="7"/>
										</div>
									</div>
								<div>
									<div class="col-lg-12 col-lg-offset-0">
										<label>Name</label>
									</div>
								</div>
								<div>
									<div class="col-lg-4">
										<div class="form-group">
											<input required id="admin_fname" name="admin_fname" class="form-control" placeholder="Given Name" maxlength="50" onkeydown ="return alphaOnly(event);"/>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<input id="admin_mname" name="admin_mname" class="form-control" placeholder="Middle Name" maxlength="15" onkeydown="return alphaOnly(event);"/>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<input required id="admin_lname" name="admin_lname" class="form-control" placeholder="Last Name" maxlength="15" onkeydown="return alphaOnly(event);"/>
										</div>
									</div>
								</div>
								<div>
									<div class="col-lg-12">
										<div class="form-group">
											<label>Address</label>
											<input required id="admin_address" name="admin_address" class="form-control" placeholder="Address" maxlength="255"/>
										</div>
									</div>
								</div>
								<div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Contact Number</label>
											<input id="admin_phone" name="admin_phone" type="text" class="form-control" placeholder="Contact Number" maxlength="12" onkeydown="return numericOnly(event);"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Birthdate</label>
											<input required id="admin_bday" name="admin_bday" type="date" class="form-control" placeholder="YYYY-MM-DD">
										</div>
									</div>
								</div>
								<div>
									<div class="col-lg-4 form-group">
											<label>Email</label>
											<input id="admin_email" name="admin_email" class="form-control" placeholder="Email Address" maxlength="12" onkeydown="return alphaOnly(event);" />
									</div>
								</div>
								<div class="">
									<div class="col-lg-12 col-lg-offset-0">
										<div class="form-group">
											<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
											<input class="btn btn-danger" type="reset" name="clear" value="Clear" /> 
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('shared.scripts');

</section>

@endsection