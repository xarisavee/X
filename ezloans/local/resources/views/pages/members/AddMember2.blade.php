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
                    <h2 class="page-header">MEMBER <small>Create</small></h2>
                </div>
            </div>

            <div class="row">
            	<form name="AddMember" method="post" action="{{ route('addmembersave', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" enctype="multipart/form-data">
	                <div class="col-lg-12">
	                    <div class="panel">
	                        <div class="panel-heading">
	                            Add New Member
	                        </div>
	                        <div class="panel-body">
	                            <div class="row">
                                	<div class="col-lg-10 col-lg-offset-1 divbreak">
                                		@if(Session::has('flash_message'))
									        <div class="alert alert-success">
									            {{ Session::get('flash_message') }}
									            {{ Session::forget('flash_message') }}
									        </div>
										@elseif ($error = $errors->first('member'))
										<div class="alert alert-danger">
											{{ $error }}
										</div>
										@endif 
                                	   		
                                		<label>Profile Details</label>
                                		
                                		<div class="row smalldivbreak">
											<div class="col-sm-6 col-lg-6 col-lg-offset-0">
												<label>Member ID Number</label>
												<input type="text" class="form-control" name="member_id" id="member_id" value="{{ $member_id }}" readonly="">
												<input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
												<input type="hidden" name="hmember_id" id="hmember_id" value="{{ $member_id }}">
												<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
											</div>
											<div class="col-sm-6 col-lg-6 col-lg-offset-0">
												<label>Account Type</label>
												<input type="text" class="form-control" id="user_type" name="user_type" value="Member" readonly="">
											</div>

											<div class="form-groupsigne">
												<div class="col-lg-12">
													<div class="form-group text-center">
														<img id="preview" src="{{ asset('images/avatar.jpeg') }}" alt="Image Preview"/>
														<input id="fileUpload" type="file" onchange="loadImageFile();" accept="image/gif, image/jpeg, image/jpg, image/png" name="emp_pic">
													</div>
												</div>
											</div>
										</div>
										<br />
	                                    <div class="smalldivbreak">
											<div class="col-sm-12 col-lg-12 col-lg-offset-0">
												<label>Name</label>
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-sm-12 col-lg-12">
												<div class="form-group">
													<input class="form-control" id="member_fname" name="member_fname" placeholder="Given Name" value="" required="">
												</div>
											</div>
											<div class="col-sm-12 col-lg-12">
												<div class="form-group">
													<input class="form-control" id="member_mname" name="member_mname" placeholder="Middle Name" value="" required="">
												</div>
											</div>
											<div class="col-sm-12 col-lg-12">
												<div class="form-group">
													<input class="form-control" id="member_lname" name="member_lname" placeholder="Last Name" value="" required="">
												</div>
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-lg-12 form-group">							
												<label>Address</label>
												<input class="form-control" id="member_address" name="member_address" placeholder="Address" value="" required="">
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-lg-6 form-group">
												<label>Sex</label>
			        	                        <select id="member_sex" name="member_sex" class="form-controlcc" required=""/>
				        	                        <option value="">...</option>
				        	                        <option value="Male">Male</option>
				        	                        <option value="Female">Female</option>
			        	                        </select>
											</div>
											<div class="col-lg-6 form-group">
												<label>Civil Status</label>
		              		                    <select id="member_civilstatus" name="member_civilstatus" class="form-controlcc" required=""/>
		              	                     		<option value="">...</option>
		              	                     		<option value="Single">Single</option>
		                                	   		<option value="Married">Married</option>
		                               	    		<option value="Separated">Separated</option>
		                                   			<option value="Widowed">Widowed</option> 	
		                                    	</select>
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-lg-6 form-group">
												<div>
													<label>Contact Number</label>
													<input type="text" id="member_landline" name="member_landline" class="form-control" placeholder="Contact Number" value="" maxlength="11">
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<div>
													<label>Landline</label>
													<input type="text" id="member_mobile" name="member_mobile" class="form-control" placeholder="Landline Number" value="" maxlength="7">
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<div>
													<label>Email Address</label>
													<input type="text" id="member_email" name="member_email" class="form-control" placeholder="Email Address" value="">
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<div>
													<label>Zip Code</label>
													<input type="number" id="member_zip" name="member_zip" class="form-control" placeholder="Zip Code" value="" maxlength="5">
												</div>
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-lg-6 form-group">
												<label>Birth Date</label>
												<input type="date" class="form-control" id="member_bday" name="member_bday" placeholder="Birthday" value="">
											</div>
											<div class="col-lg-6 form-group">
												<label>Birth Place</label>
												<input type="text" class="form-control" id="member_bplace" name="member_bplace" placeholder="Birth Place" value="">
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-lg-6 form-group">
												<label>Nationality</label>
												<input type="text" class="form-control" id="member_nationality" name="member_nationality" placeholder="Nationality" value="">
											</div>
											<div class="col-lg-6 form-group">
												<label>Religion</label>
												<input type="text" class="form-control" id="member_religion" name="member_religion" placeholder="Religion" value="">
											</div>
										</div>
									</div>	

									<div class="col-lg-10 col-lg-offset-1 form-group divbreak">
										<label>Highest Educational Attainment</label>
										<div class="smalldivbreak">
											<div class="col-lg-6 form-group">
		              		                    <select class="form-control" name="member_educAttain" id="member_educAttain" class="form-controlcc" required=""/>
		              	                     		<option value=""></option>
		              	                     		<option value="Elementary">Elementary</option>
		                                	   		<option value="High School">High School</option>
		                               	    		<option value="College">College</option>
		                                   			<option value="Vocational">Vocational</option>
		                                   			<option value="Undergraduate">Undergraduate</option>
		                                   		</select>
											</div>
											<div class="col-lg-12 form-group"><label>Name of School</label>
												<input class="form-control" id="member_school" name="member_school" placeholder="Complete Name of School" value="" required="">
											</div>
											<div class="col-lg-12 form-group"><label>School Address</label>
												<input class="form-control" value="" id="member_schooladdress" placeholder="Complete Address of School" name="member_schooladdress" required="">
											</div>
											
										</div>		
									</div>	

									
									<!-- <div class="col-lg-10 col-lg-offset-1 form-group divbreak">
										<label>Loan Co-Makers</label>
										<div class="smalldivbreak CoMakers">
											<div class="input_fields_wrap">
												<div class="comakercount col-lg-12">
													<div><h5><strong>Co-Maker 1</strong></h5></div>
													<div class="col-sm-12 col-lg-12">
														<div class="form-group">
															<label>Name</label>
															<input id="comaker_name[]" name="comaker_name[]" class="form-control" placeholder="Complete Name" value="" required="">
														</div>
													</div>
													<div class="col-sm-12 col-lg-12">
														<div class="form-group">
															<label>Address</label>
															<input id="comaker_address[]" name="comaker_address[]" class="form-control" placeholder="Complete Address" value="" required="">
														</div>
													</div>
													<div class="col-lg-6 form-group">
														<div class="form-group">
															<label>Contact Number</label>
															<input id="comaker_contact[]" name="comaker_contact[]" class="form-control" placeholder="Contact Number" value="" required="">
														</div>
													</div>
													<div class="col-lg-6 form-group">
														<div class="form-group">
															<label>Relationship</label>
															<input id="comaker_relation[]" name="comaker_relation[]" class="form-control" placeholder="Relationship" value="" required="">
														</div>
													</div>
												</div>
												 <div class="comakercount col-lg-8">
													<div id="dynamiccounter"><h5><strong>Co-Maker 2</strong></h5></div>
													<div class="col-sm-12 col-lg-12">
														<div class="form-group">
															<label>Name</label>
															<input id="comaker_name[]" name="comaker_name[]" class="form-control" placeholder="Complete Name" value="" required="">
														</div>
													</div>
													<div class="col-sm-12 col-lg-12">
														<div class="form-group">
															<label>Address</label>
															<input id="comaker_address[]" name="comaker_address[]" class="form-control" placeholder="Complete Address" value="" required="">
														</div>
													</div>
													<div class="col-sm-8 col-lg-8 form-group">
														<div class="form-group">
															<label>Contact Number</label>
															<input id="comaker_contact[]" name="comaker_contact[]" class="form-control" placeholder="Contact Number" value="" required="">
														</div>
													</div>
													<div class="col-sm-8 col-lg-8 form-group">
														<div class="form-group">
															<label>Relationship</label>
															<input id="comaker_relation[]" name="comaker_relation[]" class="form-control" placeholder="Contact Number" value="" required="">
														</div>
													</div>
												</div> 
											</div>
									</div>
										<br />
										<div class="col-sm-12 col-lg-12 text-center smalldivbreak">
											<button type="button" class="btn btn-danger addButton add_field_button">
											<i class="fa fa-plus fa-sm"></i></button>
										</div> -->
									<!-- </div> -->

									<!-- <div class="col-lg-10 col-lg-offset-1 form-group divbreak">
										<label>CoMakers</label>
										<div class="smalldivbreak">
											<p> 
											  <input type="button" value="Add Passenger" onClick="addRow('dataTable')" /> 
											  <input type="button" value="Remove Passenger" onClick="deleteRow('dataTable')" /> 
											  <p>(All acions apply only to entries with check marked check boxes only.)</p>
											</p>
											<table id="dataTable" class="form">
											 <tbody>
											  <tr>
												<p>
												<td >
													<input type="checkbox" name="chk[]" checked="checked" />
												</td>
												<td>
												<label>Name</label>
												<input type="text" name="BX_NAME[]">
												</td>
												<td>
												<label for="BX_age">Age</label>
												<input type="text" class="small"  name="BX_age[]">
												</td>
												<td>
												<label for="BX_gender">Gender</label>
												<select id="BX_gender" name="BX_gender">
													<option>....</option>
													<option>Male</option>
													<option>Female</option>
												</select>
												</td>
												<td>
												<label for="BX_birth">Berth Pre</label>
												<select id="BX_birth" name="BX_birth">
													<option>....</option>
													<option>Window</option>
													<option>No Choice</option>
												</select>
												</td>
												</p>
											  </tr>
											 </tbody>
											</table>
										</div>
									</div> -->

									<div class="col-lg-12 form-group divbreak">
										<lable>COMAKERS</lable>
										 <table class="table table-responsive table-bordered table-hover text-center table-condensed" id="comakersTable">
									        <thead>
									            <td>CoMaker #</td>
									            <td>Complete Name</td>
									            <td>Complete Address</td>
									            <td>Gender</td>
									            <td>Contact Number</td>
									            <td>Relationship</td>
									        </thead>
									        <tbody>
									            <td>1</td>
									            <td><input size=25 type="text" id="latbox"/></td>
									            <td><input size=25 type="text" id="lngbox"/></td>
									            <td><input type="button" id="delPOIbutton" value="Delete" onclick="deleteRow(this)"/></td>
									            <td><input type="button" id="addmorePOIbutton" value="Add More POIs" onclick="insRow()"/></td>
									            <td><select id="comaker_relation" name="comaker_relation">
														<option>....</option>
														<option>Mother</option>
														<option>No Choice</option>
													</select>
												</td>
									        </tbody>
									    </table>
									</div>

									<br />
									<br />
									<div class="col-lg-12 text-center btnbreak">
										<div>
											<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
											<input class="btn btn-primary" type="reset" name="clear" value="Clear" /> 
										</div>
									</div>
	                            </div>
	                        </div>
	                    </div> 
	                </div>
	            </form>
            </div>
        </div>
    </div>
    
    <script>

	$(document).ready(function() {
	    var max_fields      = 5; //maximum input boxes allowed
	    var wrapper         = $(".comakercount"); //Fields wrapper
	    var add_button      = $(".add_field_button"); //Add button ID
	    // var counter  		= document.getElementById('dynamiccounter');
	    

	    var x = 1; //initlal text box count
	    // counter.innerHTML = "CoMaker "+x;
	    $(add_button).click(function(e){ //on add input button click
	        e.preventDefault();
	        if(x < max_fields){ //max input box allowed
	            x++; //text box increment
	            $(wrapper).append('<div class="smalldivbreak CoMakers"><div class="input_fields_wrap"><div class="comakercount col-lg-12"><div><h5><strong id="dynamiccounter"></strong></h5></div><div class="col-sm-12 col-lg-12"><div class="form-group"><label>Name</label><input id="comaker_name[]" name="comaker_name[]" class="form-control" placeholder="Complete Name" value="" required=""></div></div><div class="col-sm-12 col-lg-12"><div class="form-group"><label>Address</label><input id="comaker_address[]" name="comaker_address[]" class="form-control" placeholder="Complete Address" value="" required=""></div></div><div class="col-lg-6 form-group"><div class="form-group"><label>Contact Number</label><input id="comaker_contact[]" name="comaker_contact[]" class="form-control" placeholder="Contact Number" value="" required=""></div></div><div class="col-lg-6 form-group"><div class="form-group"><label>Relationship</label><input id="comaker_relation[]" name="comaker_relation[]" class="form-control" placeholder="Relationship" value="" required=""></div></div> <a href="#" class="remove_field">Remove</a></div></div></div>'); //add input box
	        }
	        document.getElementById("dynamiccounter").innerHTML = "CoMaker "+x;
	        
	    });
	    
	    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
	        e.preventDefault(); $(this).parent('div').remove(); x--;
	    })
	});


	oFReader = new FileReader(), rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

	oFReader.onload = function (oFREvent) {

		var img=new Image();
		img.onload=function(){
			img.width=200;
			img.height=200;
			var canvas=document.createElement("canvas");
			var ctx=canvas.getContext("2d");
			canvas.width=200;
			canvas.height=200;
			ctx.drawImage(img,0,0,img.width,img.height);
			document.getElementById("preview").src = canvas.toDataURL();
		}
		img.src=oFREvent.target.result;
	};

	function loadImageFile() {
		if (document.getElementById("fileUpload").files.length === 0) { return; }
		var oFile = document.getElementById("fileUpload").files[0];
		if (!rFilter.test(oFile.type)) { alert("You must select a valid image file!"); return; }
		oFReader.readAsDataURL(oFile);
	}

	$('div.alert').not('.alert-important').delay(5000).slideUp(300);
	$('div.alert').not('.alert-danger').delay(5000).slideUp(300);

	function addRow(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if(rowCount < 5){                            // limit the user from creating fields more than your limits
			var row = table.insertRow(rowCount);
			var colCount = table.rows[0].cells.length;
			for(var i=0; i <colCount; i++) {
				var newcell = row.insertCell(i);
				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			}
		}else{
			 alert("Maximum Passenger per ticket is 5");
				   
		}
	}

	function deleteRow(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 1) {               // limit the user from removing all the fields
					alert("Cannot Remove all the Passenger.");
					break;
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}
		}
	}

	$(function () {
		$("#comakersTable").DataTable();
	});
    </script>
</section>
@endsection