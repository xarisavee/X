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
					<h2 class="page-header">Payments <small>Member Finances</small></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							Loan Book
						</div>
						<div class="panel-body">
							@if(isset($memberprofile) AND (!empty($memberprofile)))
							@foreach($memberprofile as $key => $data)
							<div id="userprofile">
								@if(isset($back))
									<form method="get" action="{{ route('paymentsviewallmembers', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id)) }}">
										<button id="backbtn" type="submit" class="btn btn-danger" onclick="backToPrevious()"><i class="fa fa-arrow-left"></i>&nbsp;Back</button>
									</form>
								@endif
								<div class="row">
									<div class="col-sm-4 col-lg-4">
										<div class="form-group text-center">
											<img id="preview" src="{{ asset('images/avatar.jpeg') }}" alt="Image Preview"/>
											<input type="hidden" id="userid" name="userid" value="{{ $data['user_id'] }}">
											<div class="col-sm-12 col-lg-12">
												<label id="profilename">{{ $data['user_fname'].' '.$data['user_lname'] }}</label>
											</div>
										</div>
									</div>
									<div class="col-sm-8 col-lg-8">
										<table id="shortprofile" class="table">
											<tr>
												<td><i class="fa fa-home fa-fw"></i></td>
												<td>{{ $data['user_address'] }}</td>
											</tr>
											<tr>
												<td><i class="fa fa-mobile fa-fw"></i></td>
												<td>{{ $data['user_mobile'] }}</td>
											</tr>
											<tr>
												<td><i class="fa fa-envelope-o fa-fw"></i></td>
												<td>{{ $data['user_email'] }}</td>
											</tr>
										</table>
										<div class="account">
											<table id="accounttable" class="table">
												<tr>
													<th>Total Share Units:</i></th>
													<td>30 units</td>
												</tr>
												<tr>
													<th>Total Share Capital:</i></th>
													<td>P 15,000. 00 &nbsp; <button id="buyshare" class="btn btn-danger" title="Buy more share."><i class="fa fa-plus"></i></button></td>
												</tr>
											</table>
										</div>
									</div>							
								</div>
								<input type="hidden" value="{{ $user_id }}">
							</div>
							@endforeach
							@endif

							<div class="row">
								<div id="LoanBook">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" id="loansTab" href="#Loans">Loans</a></li>
										<!-- <li><a data-toggle="tab" id="sharecapitalTab" href="#ShareCapital">Share Capital</a></li> -->
									</ul>

									<div class="">
										<div id="Loans" class="tab-pane fade in active">
											<div class="col-sm-12 col-lg-12 col-lg-offset-0">
												<div class="row">
													<div class="resultarea">
														<table id="memberloanstable" class="table table-responsive table-bordered table-hover text-center table-condensed">
															<thead>
																<tr>
																	<th>Loan Type</th>
																	<th>Amount</th>
																	<th>Interest Rate</th>
																	<th>Terms</th>
																	<!-- <th>Amortization</th> -->
																	<th>Start - End Date</th>
																	<th>Status</th>
																	<th>Action</th>
																</tr>
															</thead>
															@if(isset($memberloans))
															@foreach($memberloans as $loans => $data)
															<tbody>
																<tr>
																	<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
																	<td><input type="hidden" name="loanid" id="loanid" value="{{ $data['loan_user_id'] }}">
																		{{ ucwords($data['loan_name']) }}
																	</td>
																	<td>{{ "Php ".number_format($data['loan_user_amount']) }}</td>
																	<td>{{ $data['loan_user_rate']."%" }}</td>
																	<td>{{ $data['loan_user_terms']." ".$data['loan_user_duration'] }}</td>
																	<!-- <td>{{ "Php ".number_format($data['loan_user_amortization']) }}</td> -->
																	<td>{{ $data['loan_user_termstart']." - ".$data['loan_user_termend'] }}</td>
																	<td>{{ ucwords($data['loan_request_desc']) }}</td>
																	<td>
																		<button type="button" class="btn btn-danger" onclick="payloan()" title="Make payments on this loan."><i class="fa fa-money"></i></button>&nbsp;
																	</td>
																</tr>
															</tbody>
															@endforeach
															@endif
														</table>
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
			</div>
		</div>

		<div id="loanSchedModal" name="loanSchedModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="show_userid">Loan ID: </h4>
					</div>
					<div class="modal-body">
						<div id="loanSchedule" name="loanSchedule">
							<div class="form-group">
								<table class="table table-responsive table-bordered table-bordered table-condensed">
									<thead>
										<th>#</th>
										<th>Date</th>
										<th>Balance</th>
										<th>Principal</th>
										<th>Interest</th>
										<th>Amortization</th>
									</thead>
									<tbody id="loanScheduleBody">
									</tbody>
								</table>
							</div>
							<div class="form-group">
								<table class="table table-responsive table-condensed">
									<tr>
										<th>Processing Fee</th>
										<td id="procVal"></td>
									</tr>
									<tr>
										<th>Retention Fee</th>
										<td id="retVal"></td>
									</tr>
									<tr style="background-color: #fff76b;">
										<th>Total Deductions</th>
										<th id="totalDeduction"></th>
									</tr>
									<tr style="background-color: #fff76b;">
										<th>Net Loanable</th>
										<th id="netLoan"></th>
									</tr>
								</table>
							</div>
						</div>					
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
    </div>
</section>

@stop

@section('scripts')

    @include('shared.scripts');

    <script>
		$(function () {
			$("#adminsTable").DataTable();
			$("#memberloanstable").DataTable();
			$("#treasurerTable").DataTable();
			$("#membersTable").DataTable();
		});
		

		$('#membersTable').on('change', 'select', function(){
			var t = document.getElementById('membersTable');
			var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
			for (var i=0; i<rows.length; i++) {
				rows[i].onclick = function () {
					if (this.parentNode.nodeName == 'THEAD') {
						return;
					}
					var cells = this.cells; //cells collection
					var m1V = cells[0].innerHTML;
					var id = $(this).closest('tr').find('input[name="idFlag"]').val();
					$('input[id="rolesubmit"]').prop('disabled', false);
				}
			} 
		});

		function resetAll(){
			$(this).val( $(this).find("option[selected]").val() );
			$('input[id="rolesubmit"]').prop('disabled', true);
		}

		function disableSubmit(){
			$('input[id="rolesubmit"]').prop('disabled', true);
		}

		function notifyNotSaved(){
			$('div.alert').not('.alert-warning').delay(5000).slideUp(300);
		}

		$("#changeRoleForm").submit(function() {
		    if ($("input[type='submit']").val() == "Save Changes") {
		        alert("Please confirm if everything is correct.");
		        $("input[type='submit']").val("Confirm Changes");
		        
		        // Top of the PAGE
		        $(document).scrollTop(0);

		        // Top of the FORM
		        /* $(document).scrollTop( $("#uguu").offset().top ); */
		        
		        return false;
		    }
		});

		function applyLoan(){
			var userid = document.getElementById('userid').value;
			// alert(code);
			location.href="../apply/"+userid;
		}

		function payloan(){
			var userid = document.getElementById('userid').value;
			var userloanid = document.getElementById('loanid').value;
			location.href="../loanbook/"+userid+"/"+userloanid;
		}
    </script>
@stop