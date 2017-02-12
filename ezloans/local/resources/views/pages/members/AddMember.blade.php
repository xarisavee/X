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
	                <div class="col-lg-12 col-lg-offset-0">
	                    <div class="panel-group">
	                    	<div class="panel-default">
		                        <div class="panel-heading">
		                            Personal Details
		                        </div>
		                        <div class="panel-body">
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
									</div>
									<div class="row smalldivbreak">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="form-group text-center">
												<img id="preview" src="{{ asset('images/avatar.jpeg') }}" alt="Image Preview"/>
												<input id="fileUpload" type="file" onchange="loadImageFile();" accept="image/gif, image/jpeg, image/jpg, image/png" name="user_pic" id="user_pic" required="">
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
											<label>Home Address</label>
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
												<label>Mobile Number</label>
												<input type="text" id="member_mobile" name="member_mobile" class="form-control" placeholder="Contact Number" value="" maxlength="11">
											</div>
										</div>
										<div class="col-lg-6 form-group">
											<div>
												<label>Landline</label>
												<input type="text"  id="member_landline" name="member_landline" class="form-control" placeholder="Landline Number" value="" maxlength="7">
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
												<input type="text" id="member_zip" name="member_zip" class="form-control" placeholder="Zip Code" value="" maxlength="5">
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
							</div>

							<div id="spousebox" class="panel-default">
		                        <div class="panel-heading">
		                            Spouse's Details
		                        </div>
								<div class="panel-body">
		                            <div class="row">
										<div class="smalldivbreak">
											<div class="col-sm-4 col-lg-4">
												<div class="form-group">
													<label>Spouse's Name</label>
													<input class="form-control" id="member_spouse_name" name="member_spouse_name" placeholder="Complete Name" value="">
												</div>
											</div>
										</div>
										<div class="smalldivbreak">
											<div class="col-sm-4 col-lg-4">
												<div class="form-group">
													<label>Spouse's Occupation</label>
													<input class="form-control" id="member_spouse_occupation" name="member_spouse_occupation" placeholder="Occupation" value="">
												</div>
											</div>
											<div class="col-sm-4 col-lg-4">
												<div class="form-group">
													<label>Spouse's Contact Number</label>
													<input class="form-control" id="member_spouse_contact" name="member_spouse_contact" placeholder="Contact Number" value="">
												</div>
											</div>
										</div>
										<!-- <div id="Page2.1" style="display:none;">
											<div>
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
											<div class="col-lg-12 text-center">
												<button type="button" class="btn btn-danger" onclick="return show('Page2.0','Page2.1');">Back</button>
												<button type="button" class="btn btn-danger" onclick="return show('Page2.2','Page2.1');">Next</button>
											</div>	
										</div>

										<div id="Page2.2" style="display:none;">
											<div>
												<label>COMAKERS</label>
												<div class="smalldivbreak">
													<table class="table table-responsive table-bordered table-hover text-center table-condensed display" cellspacing="0" width="100%""  id="comakersTable">
												        <thead>
												            <td>Complete Name</td>
												            <td>Complete Address</td>
												            <td>Gender</td>
												            <td>Contact Number</td>
												            <td>Relationship</td>
												            <td>Actions</td>
												        </thead>
												        <tbody>
												        	<tr>
													            <td><input class="form-control" type="text" id="comaker_name[]" name="comaker_name[]" required=""></td>
													            <td><input class="form-control" type="text" id="comaker_address[]" name="comaker_address[]" required=""></td>
													            <td>
													            	<select id="comaker_sex[]" name="comaker_sex[]" class="form-control" required="">
								        	                       		<option value="">...</option>
								        	                        	<option value="Male">Male</option>
								        	                        	<option value="Female">Female</option>
							        	                        	</select>
													            </td>
													            <td><input class="form-control" type="text" id="comaker_contact[]" name="comaker_contact[]" required=""></td>
													            <td><input class="form-control" type="text" id="comaker_relation[]" name="comaker_relation[]" required="">
																</td>
																<td>
																	<button type="button" class="btn btn-primary" id="addmorebutton" title="Add CoMaker" onclick="addRow();"><i class="fa fa-plus"></i></button>
													            </td>
													        </tr>
												        </tbody>
												    </table>
												</div>
											</div> -->
										</div>
		                            </div>
		                        </div>
		                    </div>

							<div class="panel-default">
		                        <div class="panel-heading">
		                            Occupation and Finances
		                        </div>
								<div class="panel-body">
		                            <div class="row">
										<div class="col-sm-4 col-lg-4">
											<div class="form-group">
												<label>Employment Sector Type</label>
	                            				<select id="member_empsector" name="member_emp_sector" class="form-control" required=""/>
		              	                     		<option value="">...</option>
		              	                     		<option value="Private">Private</option>
		                                	   		<option value="Public">Public</option>
		                               	    		<option value="Self-Employed">Self-Employed</option>
		                                   			<option value="Others">Others</option> 	
		                                    	</select>
		                            		</div>
		                            	</div>
		                            	<div id="employeesector" class="col-sm-4 col-lg-4">
		                            		<div class="form-group">
		                            			<label>Please specify</label>
		                            			<input type="text" class="form-control" id="member_empsector_other" name="member_empsector_other" value="">
		                            		</div>
		                            	</div>
		                            </div>
		                           	<div class="row">
		                            	<div class="col-sm-6 col-lg-6">
											<div class="form-group">
												<label>Member's Occupation</label>
												<input type="text" class="form-control" id="member_emp_occupation" name="member_emp_occupation" placeholder="Occupation" value="" required="">
											</div>
											<div class="form-group">
												<label>Employer/Business Name</label>
												<input type="text" class="form-control" id="member_emp_name" name="member_emp_name" placeholder="Employer/Business Name" value="" required="">
											</div>
		                            		<div class="form-group">
		                            			<label>Employer/Business Address</label>
												<input type="text" class="form-control" id="member_emp_address" name="member_emp_address" placeholder="Employer/Business Address" value="" required="">
											</div>
											<div class="form-group">
												<label>Employer/Business Number</label>
												<input type="text" class="form-control" id="member_emp_contact" name="member_emp_contact" placeholder="Contact Number" value="" required="">
											</div>
										</div>
									</div>
									<div>
										<div class="col-lg-12 text-center btnbreak">
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
	function show(shown, hidden) {
	  document.getElementById(shown).style.display='block';
	  document.getElementById(hidden).style.display='none';
	  return false;
	}
	

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


	function deleteRow(row){
	    var i=row.parentNode.parentNode.rowIndex;

	    if (i > 1){
	    	document.getElementById('comakersTable').deleteRow(i);
	    }else{
	    	return false;
	    }
	    
	}

	function addRow(){
		var newRowContent = '<tr><td><input class="form-control" type="text" id="comaker_name[]" name="comaker_name[]" required=""></td><td><input class="form-control" type="text" id="comaker_address[]" name="comaker_address[]" required=""></td><td><select id="comaker_sex[]" name="comaker_sex[]" class="form-control" required=""><option value="">...</option><option value="Male">Male</option><option value="Female">Female</option></select></td><td><input class="form-control" type="text" id="comaker_contact[]" name="comaker_contact[]" required=""></td><td><input class="form-control" type="text" id="comaker_relation[]" name="comaker_relation[]" required=""></td><td><button type="button" class="btn btn-danger" id="delBtn" title="Add CoMaker" onclick="deleteRow(this);"><i class="fa fa-minus"></i></button></td></tr>';
		$("#comakersTable tbody").append(newRowContent); 
	}

	$("#member_civilstatus").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Married"){
                $("#spousebox").show();
            }else{
            	$("#spousebox").hide();
            }
        });
    }).change();

    $("#member_empsector").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Others"){
                $("#employeesector").show();
            }else{
            	$("#employeesector").hide();
            }
        });
    }).change();

    </script>
</section>
@endsection