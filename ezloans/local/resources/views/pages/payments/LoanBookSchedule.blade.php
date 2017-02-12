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
					<h2 class="page-header">Member <small>Finances</small></h2>
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
								<div class="row">
									<div class="col-sm-4 col-lg-4">
										<div class="form-group text-center">
											<img id="preview" src="
												@if(empty($data['user_photo']))
													{{ asset('local/storage/app/avatars/avatar.jpeg') }}
												@else 
													{{ asset($data['user_photo']) }}
												@endif

												" alt="Image Preview"/>
											<input type="hidden" id="userid" name="userid" value="{{ $data['user_id'] }}">
											<div class="row">
												<button id="makepaymentbtn" class="btn btn-danger" data-toggle="modal" data-target="#paymentModal">Make Payment</button>
											</div>
										</div>
									</div>
									<div class="col-sm-8 col-lg-8">
										<table id="shortprofile" class="table">
											<tr>
												<td colspan="2"><label id="profilename">{{ $data['user_fname'].' '.$data['user_lname'] }}</label></td>
											</tr>
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
													<th>Total Share Capital:</i></th>
													<td>P {{ number_format($totalshare) }}</td>
												</tr>
											</table>
										</div>
									</div>							
								</div>
								<input type="hidden" value="{{ $user_id }}">
							</div>
							@endforeach
							@endif

							<div class="row smalldivbreak">
								<div class="col-sm-6 col-lg-6">
									<table id="shortloandesc" class="table table-condensed">
										<!-- <label>LOAN DETAILS</label> -->
										<tr>
											<th>Loan Type:</th>
											<td> {{ $memberloans['loan_name'] }}</td>
										</tr>
										<tr>
											<th>Loan ID:</th>
											<td> {{ $memberloans['loan_user_id'] }}</td>
										</tr>
										<tr>
											<th>Loan Amount:</th>
											<td> {{ $memberloans['loan_user_amount'] }}</td>
										</tr>
										<tr>
											<th>Interest Rate:</th>
											<td> {{ $memberloans['loan_user_rate']."%" }}</td>
										</tr>
										<tr>
											<th>Terms:</th>
											<td> {{ $memberloans['loan_user_terms']." ".$memberloans['loan_user_duration'] }}</td>
										</tr>
										<tr>
											<th>Released:</th>
											<td> {{ $memberloans['loan_user_termstart'] }}</td>
										</tr>
										<tr>
											<th>Maturity:</th>
											<td> {{ $memberloans['loan_user_termend'] }}</td>
										</tr>
										<tr>
											<th>Status:</th>
											<td> {{ $memberloans['loan_request_desc'] }}</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row" id="LoanBook">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" id="loansTab" href="#LoanSched">Loan Schedule</a></li>
									<li><a data-toggle="tab" id="payhistoryTab" href="#RepaymentHistory">Payment History</a></li>
									<li><a data-toggle="tab" id="pendingduesTab" href="#PendingDues">Pending Dues</a></li>
									<li><a data-toggle="tab" id="collateralTab" href="#Collateral">Collaterals</a></li>
								</ul>

								<div class="tab-content">
									<div id="LoanSched" class="tab-pane fade in active">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<div class="row smalldivbreak">
														<button id="printsched" class="btn btn-danger"><i class="fa fa-print"></i></button>
													</div>
													<div class="row smalldivbreak">
														<table id="memberloanstable" class="table table-responsive table-bordered table-hover text-center table-condensed">
															<thead>
																<tr>
																	<th>#</th>
																	<th>Date</th>
																	<th>Balance</th>
																	<th>Principal</th>
																	<th>Interest</th>
																	<th>Amortization</th>
																</tr>
															</thead>
															@if(isset($schedule))
															<tbody id="loanScheduleBody">
																@foreach($schedule as $sched)
																<tr>
																	@foreach($sched as $key => $value)
																	<td>{{ $sched[$key] }}</td>
																	@endforeach
																</tr>
																@endforeach
															</tbody>
															
															@endif
														</table>
													</div>
												</div>
											</div>	
										</div>
									</div>

									<div id="RepaymentHistory" class="tab-pane fade in">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<div class="row smalldivbreak">
														<button id="printrepayments" class="btn btn-danger"><i class="fa fa-print"></i></button>
													</div>
													<div class="row smalldivbreak">
														<table id="paymentloanstable" class="table table-responsive table-bordered table-hover text-center table-condensed">
														<thead>
															<tr>
																<th>Date</th>
																<th>Loan #</th>
																<th>Amount</th>
																<th>Penalty</th>
																<th>Other Fees</th>
																<th>Total Paid</th>
																<th>Collector</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														</table>
													</div>
												</div>
											</div>	
										</div>
									</div>

									@if(isset($pendingdues) AND (!empty($pendingdues)))
									<div id="PendingDues" class="tab-pane fade in">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<div class="row smalldivbreak">
														<table class="table table-responsive table-bordered table-hover text-center table-condensed">
															<tr>
																<th class="basedrow">Based on Loan Terms</th>
																<td><strong>Principal</strong></td>
																<td><strong>Interest</strong></td>
																<td><strong>Fees</strong></td>
																<td><strong>Penalty</strong></td>
																<td><strong>Total</strong></td>
															</tr>
															<tr>
																<th>Total Due</th>
																<td>{{ number_format(round($pendingdues[0]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[0]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[0]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[0]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[0]['total'], 2)) }}</td>
															</tr>
															<tr>
																<th>Total Paid</th>
																<td>{{ number_format(round($pendingdues[1]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[1]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[1]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[1]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[1]['total'], 2)) }}</td>
															</tr>
															<tr>
																<th>Balance</th>
																<td>{{ number_format(round($pendingdues[2]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[2]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[2]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[2]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[2]['total'], 2)) }}</td>
															</tr>
														</table>
													</div>
													<div class="row smalldivbreak">
														<table class="table table-responsive table-bordered table-hover text-center table-condensed">
															<tr>
																<th class="basedrow">Based on Loan Schedule</th>
																<td><strong>Principal</strong></td>
																<td><strong>Interest</strong></td>
																<td><strong>Fees</strong></td>
																<td><strong>Penalty</strong></td>
																<td><strong>Total</strong></td>
															</tr>
															<tr>
																<th>Due til {{ $pendingdues[3]['duedate'] }}</th>
																<td>{{ number_format(round($pendingdues[3]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[3]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[3]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[3]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[3]['total'], 2)) }}</td>
															</tr>
															<tr>
																<th>Balance til {{ $pendingdues[4]['duedate'] }}</th>
																<td>{{ number_format(round($pendingdues[4]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[4]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[4]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[4]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[4]['total'], 2)) }}</td>
															</tr>
															<tr>
																<th>Payment til {{ $pendingdues[5]['duedate'] }}</th>
																<td>{{ number_format(round($pendingdues[5]['principal'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[5]['interest'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[5]['fees'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[5]['penalty'], 2)) }}</td>
																<td>{{ number_format(round($pendingdues[5]['total'], 2)) }}</td>
															</tr>
														</table>
													</div>
												</div>
											</div>	
										</div>
									</div>
									@endif

									<div id="Collateral" class="tab-pane fade in">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<div class="row smalldivbreak">
														<table class="table table-responsive table-bordered table-hover text-center table-condensed">
															<tr>
																<th class="basedrow">Based on Loan Terms</th>
																<td><strong>Principal</strong></td>
																<td><strong>Interest</strong></td>
																<td><strong>Fees</strong></td>
																<td><strong>Penalty</strong></td>
																<td><strong>Total</strong></td>
															</tr>
															<tr>
																<th>Total Due</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<th>Total Paid</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<th>Balance</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</table>
													</div>
													<div class="row smalldivbreak">
														<table class="table table-responsive table-bordered table-hover text-center table-condensed">
															<tr>
																<th class="basedrow">Based on Loan Schedule</th>
																<td><strong>Principal</strong></td>
																<td><strong>Interest</strong></td>
																<td><strong>Fees</strong></td>
																<td><strong>Penalty</strong></td>
																<td><strong>Total</strong></td>
															</tr>
															<tr>
																<th>Due til</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<th>Balance til</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
															<tr>
																<th>Payment til</th>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</table>
													</div>
												</div>
											</div>	
										</div>
									</div>
								</div>

								<div class="row">
									<button type="button" class="gobackbtn" class="btn btn-link">Back</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <div id="paymentModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

		<form method="post" action="{{ route('memberloanpaymentformschedule', array('domain' => $domain, 'user_id' => $userinfo['user_id'], 'member_id' => $member_id, 'loan_user_id' => $loan_user_id)) }}">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">PAY LOAN AMORTIZATION</h4>
				</div>
					<div class="modal-body">
						<div id="makePayment" name="makePayment">
							<input type="hidden" name="paymentcount" id="paymentcount">
							<div class="row">
								<label>OR No.: {{ $ornumber }}</label>
								<input type="hidden" class="form-control" name="ornumber" id="ornumber" value="{{ $ornumber }}" readonly="" required="">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
							</div>
							<div class="form-group">
								<label>Transaction Date: {{ date('m-d-Y') }}</label>
								<input type="hidden" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" readonly="">
							</div>	
							<div class="form-group">
								<label>Amount collected:</label>
								<input type="hidden" id="member_id" name="member_id">
								<input type="text" class="form-controlcc" id="transaction_amount" name="transaction_amount">
							</div>
							<div class="row">
								<div class="resultarea">

								</div>
							</div>
						</div>
					</div>
				<div class="modal-footer">
					<div class="row">
						<small>Processed by: {{ ucwords($userinfo['user_fname'].' '.$userinfo['user_lname']) }} </small>
						<input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user_id }}" readonly="">
					</div>
					<div class="row">
						<input type="submit" class="btn btn-danger" value="PAY" id="submitpayment" name="submitpayment">
					</div>
				</div>
			</div>
			</form>

		</div>
	</div>
</section>

@stop

@section('scripts')

    @include('shared.scripts');

    <script>
		$(function () {
			$("#adminsTable").DataTable();
			$("#paymentloanstable").DataTable();
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

		/*function showSchedule(){
			var loan_user_id = document.getElementById('loanid').value;
			var member_id = document.getElementById('userid').value;
			var url = window.location+'/loandetails/'+loan_user_id;
			var token = $('meta[name="csrf-token"]').attr('content');

			$.ajax({
	            url: ''+url,
	            type: "GET",
	            params: {_token:token},
	            data: ({ loan_user_id : loan_user_id,
	            		member_id : member_id
	             }),
	            // dataType: 'json',
	            success:function(data) {

	            	var memberdetails = data;
	            	var Amount;
	            	var Rate;
	            	var RetentionFee;
	            	var ProcessingFee;
	            	var Terms;
	            	var ReleaseDate;
	            	var InterestMethod;
	            	var Accumulation;
	            	var Duration;
	            	var Repayment;
	            	var method;
	            	var totalDeduction;
	            	var netLoan;
	            	var RetentionAmount;

	            	$.each(memberdetails, function(index, key) {
	            		Amount = parseFloat(key.loan_user_amount);
		            	Rate = key.loan_user_rate;
		            	RetentionFee = parseFloat(key.loan_user_retention);
		            	ProcessingFee = parseFloat(key.loan_user_processing);
		            	Terms = key.loan_user_terms;
		            	ReleaseDate = key.loan_user_termstart;
		            	InterestMethod = key.loan_user_interest_method;
		            	Accumulation = key.loan_user_accumulation;
		            	Duration = key.loan_user_duration;
		            	Repayment = key.loan_user_repayment;
		            	method = InterestMethod;
                    });
	            	
                    if(method == '1'){
			    		url = window.location+"/flatrate";
			    	}
			    	else if(method == '2'){
			    		url = window.location+"/equalAmort";
			    	}
			    	else if(method == '3'){
			    		url = window.location+"/equalPrincipal";
			    	}
			    	else if(method == '4'){
			    		url = window.location+"/interestOnly";
			    	}
			    	else{
			    		url = window.location;
			    	}

			    	console.log(url);
                    $.ajax({
			            url: ''+url,
			            type: "GET",
			            params: {_token:token},
			            data: ({ Amount : Amount,
			            	Rate: Rate,
			            	RetentionFee: RetentionFee,
			            	ProcessingFee : ProcessingFee,
			            	Terms : Terms,
			            	ReleaseDate : ReleaseDate,
			            	InterestMethod : InterestMethod,
			            	Accumulation : Accumulation,
			            	Duration : Duration,
			            	Repayment : Repayment,
			             }),
			            // dataType: 'json',
			            success:function(loandata) {

			            	var trHTML = '';

			            	$.each(loandata, function(index, key) {
			            		trHTML += '<tr>';

				            	for(var i = 0; i < key.length; i++){
				            		if((i == '2') || (i == '3') || (i =='5')) {
				            			trHTML += '<td>'+Number(key[i]).toLocaleString('en')+'</td>';
				            		}else{
				            			trHTML += '<td>'+key[i]+'</td>';
				            		}
					            }
				            	trHTML += '</tr>';
			            	});

			            	RetentionAmount = parseFloat((RetentionFee/100) * Amount);
			            	totalDeduction = parseFloat(ProcessingFee + RetentionAmount);
			            	netLoan = parseFloat(Amount - totalDeduction);

			            	$("#loanScheduleBody").empty();
			            	$("#loanScheduleBody").append(trHTML);
			            	$("#show_userid").text("Loan #: "+loan_user_id);
			            	$("#procVal").text(ProcessingFee);
			            	$("#retVal").text(RetentionAmount);
			            	$("#totalDeduction").text(totalDeduction);
			            	$("#netLoan").text(netLoan);
    						jQuery("#loanSchedModal").modal('show');
			            }
			        });

	            	
	            }
	        });
		}*/

		function showSchedule(){
			var t = document.getElementById('memberloanstable');
			var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
			for (var i=0; i<rows.length; i++) {
				rows[i].onclick = function () {
					if (this.parentNode.nodeName == 'THEAD') {
						return;
					}
					var cells = this.cells; //cells collection
					var loan_user_id = cells[0].innerHTML;
					var url = window.location+"/schedule/"+loan_user_id;
					location.href = url;
				}
			}
		}

    </script>
@stop