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
                    <h2 class="page-header">LOANS <small>Apply Loan</small></h2>
                </div>
            </div>

            <div class="row">
            	<form name="enlistCoMaker" method="post" action="{{ route('applynewloan', array('domain' => $domain, 'user_id' => $userinfo['user_id'], 'member_id' => $member_id)) }}" enctype="multipart/form-data">
	                <div class="col-lg-12">
	                    <div class="panel">
	                        <div class="panel-heading">
	                            Enlist CoMakers
	                        </div>
	                        <div class="panel-body">
	                            <div class="row">
                                	<div class="col-lg-12">
										<label>COMAKERS</label>
										<p>A co-maker is a person who, by contract, promises to pay a borrower's loan if that person fails to do so.</p>
										<div class="form-group">
											<div class="smalldivbreak">
												<input type="hidden" id="memberid" name="memberid" value="{{ $member_id }}">
												<table class="table table-responsive table-bordered table-hover text-center table-condensed" cellspacing="0" id="comakersTable">
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
										</div>
										<div>
											<div class="col-lg-12 text-center btnbreak">
												<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
												<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
												<input class="btn btn-primary" type="reset" name="clear" value="Clear" /> 
											</div>
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

    </script>
</section>
@endsection