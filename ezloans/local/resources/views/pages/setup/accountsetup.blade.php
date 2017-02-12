@extends('layouts.setuplayout')

@section('setupcontent')
	<div id="page-wrappersign">
        <div id="centersign" class="panel">
            <div class="panel-heading">
            	SETUP YOUR BUSINESS'S ACCOUNT
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="completeclient" action="{{ route('companysetupsave') }}" method="post" enctype="multipart/form-data">
			                <div class="col-lg-12">
			                    <div class="panel">
			                        <div class="panel-body">
			                            <div class="row">                	
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
		                                		<div class="col-lg-12 col-lg-offset-0 divbreak">   		
			                                		<h4><strong>Cooperative Details</strong></h4>
			                                		<div class="smalldivbreak">
														<div class="col-lg-4 form-group">							
															<label>FIRST NAME</label>
															<input class="form-control" id="user_fname" name="user_fname" placeholder="First Name" value="" required="">
														</div>
														<div class="col-lg-4 form-group">							
															<label>MIDDLE NAME</label>
															<input class="form-control" id="user_mname" name="user_mname" placeholder="Middle Name" value="" required="">
														</div>
														<div class="col-lg-4 form-group">							
															<label>LAST NAME</label>
															<input class="form-control" id="user_lname" name="user_lname" placeholder="Last Name" value="" required="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>BUSINESS NAME</label>
															<input class="form-control" id="coop_name" name="coop_name" placeholder="Business Name" value="{{ $clientinfo['comp_name'] }}" required="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>BUSINESS ADDRESS</label>
															<input class="form-control" id="coop_address" name="coop_address" placeholder="Business Address" value="" required="">
														</div>
														<!-- <div class="col-lg-12">
															<div style="height:400px; width:400px; margin-left: auto; margin-right: auto; margin-bottom: 20px;" id="map-canvas"></div>
														</div> -->
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>CONTACT NUMBER</label>
															<input class="form-control" id="coop_contact" name="coop_contact" placeholder="Business Contact Number" value="" required="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>EMAIL ADDRESS</label>
															<input class="form-control" id="coop_email" name="coop_email" placeholder="User Email Address" value="{{ $clientinfo['user_email'] }}" required="" readonly="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>DOMAIN NAME</label>
															<input class="form-control" id="coop_domain" name="coop_domain" placeholder="yourbusiness.ezloans.com" value="" required="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>PASSWORD</label>
															<input type="password" class="form-control" id="user_password" name="user_password" value="" required="">
														</div>
													</div>
													<div class="smalldivbreak">
														<div class="col-lg-12 form-group">							
															<label>RETYPE PASSWORD</label>
															<input type="password" class="form-control" id="user_password2" name="user_password2" onkeyup="return checkPassMatch('user_password','user_password2');" value="" required="">
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12 text-center btnbreak">
												<div>
													<input class="btn btn-danger" id="setupsubmit" name="setupsubmit" type="submit" name="submit" value="Submit" disabled="" /> 
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
        </div>
    </div>
@stop

<script type="text/javascript">

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

	function alphaOnly(event) {
		var key = event.keyCode;
		return ((key >= 65 && key <= 90) || key == 8 || key == 32 || (key >= 37 && key <=40 ) || key == 9);
	};

	function numericOnly(event){
		var key = event.keyCode;
		return ((key >=48 && key <=57) ||  key == 43 || key == 32 || key == 8 || (key >= 37 && key <=40 ) || key == 9);
	};

	function disableSubmit(){
		$('input[id="rolesubmit"]').prop('disabled', true);
	}

	function checkPassMatch(user_password,user_password2){
		var password = document.getElementById(user_password);
		var password2 = document.getElementById(user_password2);
		var goodColor = "#66cc66";
		var badColor = "#a94442";

		if(password.value == password2.value){
			password2.style.borderColor = goodColor;
			$('input[id="setupsubmit"]').prop('disabled', false);
		}else{
			password2.style.borderColor = badColor;
		}
	}
</script>