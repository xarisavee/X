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
            	<form name="AddMember" method="post" action="{{ route('updatecompany', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" enctype="multipart/form-data">
	                <div class="col-lg-12 col-lg-offset-0">
	                    <div class="panel-group">
	                    	<div class="panel-default">
		                        <div class="panel-heading">
		                            COOPERATIVE'S PROFILE
		                        </div>
		                        <div class="panel-body">
									<div class="row">
										<div class="col-sm-6 col-lg-6 col-lg-offset-0">
											<form name="SetupCoop" action="{{ route('updatecompany', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" method="post">
								                <div class="col-lg-10 col-lg-offset-1"> 
								                <fieldset id="editableFields" disabled="disabled">  		
								                	<div class="form-group">
								                   		<h4><strong>Cooperative Details</strong></h4>
								                   		<input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
														<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
														@if(isset($companydetails) AND (!empty($companydetails)))
														@foreach($companydetails as $key => $data)
								                	  	<div class="smalldivbreak">
															<div class="col-sm-12 col-lg-12">
																<label>Name</label>
																<div class="form-group">
																	<input class="form-control" id="coop_name" name="coop_name" placeholder="Complete Name of Cooperative" value="{{ $data['coop_name'] }}" required="">
																</div>
															</div>
															<div class="col-sm-12 col-lg-12">
																<label>Address</label>
																<div class="form-group">
																	<input id="coop_address" name="coop_address" id="coop_address" placeholder="Complete Address" class="form-control" value="{{ $data['coop_address'] }}" required=""/>
																</div>
															</div>
															<div class="col-sm-12 col-lg-12">
																<label>Foundation Date</label>
																<div class="form-group">
																	<input type="date" class="form-control" id="coop_foundationdate" name="coop_foundationdate" placeholder="Contact Number" value="" required="">
																</div>
															</div>
														</div>
														<div class="smalldivbreak">
															<div class="col-lg-6 form-group">
																<div>
																	<label>Contact Number</label>
																	<input type="text" class="form-control" id="coop_contact" name="coop_contact" placeholder="Landline Number" value="{{ $data['coop_contact'] }}"  required="">
																</div>
															</div>
														</div>
														<div class="smalldivbreak">
															<div class="col-sm-12 col-lg-12">
																<label>Authorized Share Capital</label>
																<div class="form-group input-group">
																	<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-rub fa-lg fa-inverse"></i></span>
																	<input type="text" id="coop_authsharecapital" name="coop_authsharecapital" class="form-controlcc" value="{{ $data['coop_authsharecapital'] }}" required=""/>
																</div>
															</div>
															<div class="col-sm-12 col-lg-12">
																<label>Share Capital</label>
																<div class="form-group input-group">
																	<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-rub fa-lg fa-inverse"></i></span>
																	<input type="text" id="coop_sharecapital" name="coop_sharecapital" class="form-controlcc" value="{{ $data['coop_sharecapital'] }}"required=""/>
																</div>
															</div>
														</div>
													</div>
													@endforeach
													@endif
												</div>
												</fieldset>
												<div class="col-lg-12 text-center btnbreak">
													<div>
														<input type="button" class="btn btn-warning" id="enable" name="enable" value="Edit Profile" onclick="enableEdit();"/>
														<input class="btn btn-danger" type="submit" name="submit" id="profilesubmit" name="profilesubmit" value="Save Changes" disabled="" /> 
													</div>
												</div>
								            </form>
								        </div>
									</div>
								</div>
							</div>

							<div id="spousebox" class="panel-default">
		                        <div class="panel-heading">
		                            SYSTEM FEATURES
		                        </div>
								<div class="panel-body">
		                            <div class="col-lg-10 col-lg-offset-1">
										<form id="SetFeatures" name="SetFeatures" action="" method="post">
											<div>
												<table class="table" id="featurestable">
													<thead>
														<tr>
															<th colspan="2">Features</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th>MEMBERS</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Add New Member</li>
																<li>View/Update Members' Profile</li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>LOANS</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Add New Loan Type</li>
																<li>Loan Overview</li>
																<li>Rates</li>
																<li>Penalty</li>
																<li>Loan Requests</li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>PAYMENTS</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Loan Book</li>
																<li>Pay Member Loan Installment</li>
																<li>Buy Share Capital</li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>ADMIN</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Add New User</li>
																<li>View/Edit Profile</li>
																<li>Deactivate Account</li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>ROLES</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Add New Role</li>
																<li>Display Roles</li> 
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>REPORTS</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li>Generate Report</li>
																<li>Audit Trail</li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
																<li style="list-style-type:none">
																	<div>
																		<i class="fa fa-check-circle"></i>
																	</div>
																</li>
															</td>
														</tr>
														<tr>
															<th>LOAN RESTRUCTURING</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none"><p>Loan restructuring is a feature that will <i>alter the loan terms of a borrower to make a more favorable term</i>. <br /><br /> For example, the borrower may restructure a loan to receive a lower interest rate or monthly payment. Restructured loans are most common if the borrower states that he/she can no longer afford payments under the old terms.</p></li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none" class="centericon">
																	<label class="switch">  
												                        <input name="restructuringbtn" id="restructuringbtn" type="checkbox" checked>
												                        <div class="slider round"></div>
											                      	</label>
																</li>
															</td>
														</tr>
														<tr>
															<th>LOAN COLLATERAL</th>
															<td>
																<li style="list-style-type:none">&nbsp;</li>
																<li style="list-style-type:none"><p>Collateral is a property or other asset that a borrower offers as a way for a lender to secure the loan. If the borrower stops making the promised loan payments, the lender can seize the collateral to recoup its losses. Since collateral offers some security to the lender should the borrower fail to pay back the loan, loans that are secured by collateral typically have lower interest rates than unsecured loans.</p></li>
															</td>
															<td class="indicator">
																<li style="list-style-type:none" class="centericon">
																	<label class="switch">  
											                        	<input name="collateralbtn" id="collateralbtn" type="checkbox" checked>
											                        	<div class="slider round"></div>
											                      	</label>
																</li>
															</td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>
																<div class="form-group centericon">
											                		<input type="hidden" name="_token" id="_token" value="{{ Session::token() }}">
																	<input class="btn btn-danger" type="submit" name="submit" value="Save" /> 
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>    
										</form>
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

	function enableEdit(){
		$("#editableFields").prop("disabled", false);
		$('input[id="profilesubmit"]').prop('disabled', false);
	}

    </script>
</section>
@endsection