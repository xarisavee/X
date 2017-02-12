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
                    <h2 class="page-header">MEMBER <small>Update</small></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            Update Members
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <div>
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<label>Name</label>
										</div>
									</div>
									<div>
										<div class="col-sm-4 col-lg-4">
											<div class="form-group">
												<input class="form-control" placeholder="Given Name" value="<?php //echo $res['stud_Fname'] ?>" readonly>
											</div>
										</div>
										<div class="col-sm-4 col-lg-4">
											<div class="form-group">
												<input class="form-control" placeholder="Middle Name" value="<?php// echo $res['stud_Mname']; ?>" readonly>
											</div>
										</div>
										<div class="col-sm-4 col-lg-4">
											<div class="form-group">
												<input class="form-control" placeholder="Last Name" value="<?php //echo $res['stud_Lname']; ?>" readonly>
											</div>
										</div>
									</div>
									<div>
										<div class="col-lg-12 form-group">
											<div>
												<label>Address</label>
												<input class="form-control" placeholder="Address" value="<?php //echo $res['stud_Add']; ?>" readonly>
											</div>
										</div>
									</div>
									<div>
										<div class="col-lg-6 form-group">
											<div>
												<label>Contact Number</label>
												<input type="number" class="form-control" placeholder="Contact Number" value="<?php //echo $res['stud_Contact']; ?>" readonly>
											</div>
										</div>
										<div class="col-lg-6 form-group">
											<div>
												<label>Zip Code</label>
												<input type="number" class="form-control" placeholder="Zip Code" value="<?php //echo $res['stud_Zip']; ?>" readonly>
											</div>
										</div>
									</div>
									<div>
										<div class="col-lg-6 form-group">
												<label>Birth Date</label>
												<input type="date" class="form-control" placeholder="Contact Number" value="<?php// echo $res['stud_Bday']; ?>" readonly>
										</div>
										<div class="col-lg-6 form-group">
												<label>Birth Place</label>
												<input class="form-control" placeholder="Zip Code" value="<?php// echo $res['stud_Bplace']; ?>" readonly>
										</div>
									</div>
									<div>
										<div class="col-lg-4 form-group">
												<label>Nationality</label>
												<input class="form-control" placeholder="Nationality" value="<?php //echo $res['stud_Nationality']; ?>" readonly>
										</div>
										<div class="col-lg-4 form-group">
											<label>Civil Status</label>
											<input class="form-control" placeholder="Civil Status" value="<?php //echo $res['stud_Civilstatus']; ?>" readonly>
										</div>
										<div class="col-lg-4 form-group">
											<label>Sex</label>
											<input class="form-control" placeholder="Sex" value="<?php //echo $res['stud_Sex']; ?>" readonly>
										</div>
									</div>
									<div>
										<div class="col-lg-12 form-group">
											<label>Languages & Dialects Spoken</label>
											<input class="form-control" placeholder="Language1/Dialect1, Language2/Dialect2, etc." value="<?php //echo $res['language']; ?>" readonly>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

</section>

@endsection