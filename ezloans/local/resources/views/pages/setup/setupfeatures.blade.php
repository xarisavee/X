@extends('layouts.setuplayout')

@section('setupcontent')
	<div id="page-wrappersign">
	    <div id="centersign" class="panel">
	        <div class="panel-heading">
	        	System Features Setup
	        </div>
			<div class="panel">
				<div class="panel-body">
		          <div class="row">
		            <div class="col-lg-10 col-lg-offset-1">
		              <form id="SetFeatures" name="SetFeatures" action="{{ route('setupfeaturescomplete', array($user_id)) }}" method="post">
						<div class="divbreak">
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
												<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
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
@stop