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
					<h2 class="page-header">Payments</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							Payment Form
						</div>
						<div class="panel-body">
							<form method="post" action="{{ route('savepaymentform', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">
								<div class="row smalldivbreak">
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<label>OR No.: {{ $ornumber }}</label>
											<input type="hidden" class="form-control" name="ornumber" id="ornumber" value="{{ $ornumber }}" readonly="" required="">
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
										</div>
									</div>
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<label>Transaction Date: {{ date('m-d-Y') }}</label>
											<input type="hidden" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" readonly="">
										</div>
									</div>
								</div>
								<div class="row smalldivbreak">
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<label>Member Number:</label>
											<input type="text" class="form-control" name="transaction_idmember" id="transaction_idmember" placeholder="Enter member number" required="">
										</div>
									</div>
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<label>Member Name:</label>
											<input type="text" class="form-control" name="transaction_member" id="transaction_member" readonly="" required="">
										</div>
									</div>
								</div>
<!-- 								<div class="row smalldivbreak">
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<button type="button" class="btn btn-primary" id="addmorebutton" title="Make Loan Payment" data-toggle="modal" data-target="#LoanPaymentModal"><i class="fa fa-plus"></i>&nbsp;Make Loan Payment</button>
										</div>
									</div>
								</div> -->

								<br />
								<div class="row smalldivbreak col-sm-12 col-md-12 col-lg-12 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
									<div class="col-sm-10 col-md-10 col-lg-10 col-lg-offset-1 text-center">
										<table id="transactionTable" class="table table-responsive table-hover table-condensed ">
											<thead>
												<tr class="titleRow">
													<th>TRANSACTION</th>
													<th>DESCRIPTION / LOAN ID</th>
													<th>AMOUNT</th>
													<th>&nbsp;</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<select id="transaction_type[]" name="transaction_type[]" class="form-control">
															<option value="0"></option>
															<option value="ShareCapital">Share Capital Purchase</option>
															<option value="OtherPayment">Other Payments</option>
															<option value="LoanPayment">Loan Payments</option>			
														</select>
													</td>
													<td>
														<input type="text" class="form-control" name="transaction_desc[]" id="transaction_desc[]">
													</td>
													<td class="amountCell">
														<input type="text" class="form-control" name="transaction_payment[]" class="transaction_payment" id="transaction_payment[]">
													</td>
													<td>
														<button type="button" class="btn btn-primary" id="addmorebutton" title="Add Transaction" onclick="addRow();"><i class="fa fa-plus"></i></button>
										            </td>
												</tr>
											</tbody>
										</table>
														
									</div>
								</div>
								<br />
								<br />
								<div class="row smalldivbreak text-center">
									<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
									<input class="btn btn-primary" type="reset" name="clear" value="Clear" /> 
								</div>
								<div class="row smalldivbreak">
									<div class="col-sm-6 col-lg-6 col-lg-offset-0">
										<div class="row">
											<small>Processed by: {{ ucwords($userinfo['user_fname'].' '.$userinfo['user_lname']) }} </small>
											<input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $user_id }}" readonly="">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

	<div id="LoanPaymentModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Make a loan payment.</h4>
				</div>
				<div class="modal-body">
					<div id="makePayment" name="makePayment">
						<input type="hidden" name="paymentcount" id="paymentcount">	
						<div class="form-group">
							<label>Loan ID</label>
							<input type="hidden" id="member_id" name="member_id">
							<input type="text" class="form-controlcc" id="loan_user_id" name="loan_user_id" onkeydown="getLoanDetails()">
						</div>
						<div class="row">
							<div class="resultarea">
								<table id="loanScheduleTbl" class="table table-responsive table-bordered table-bordered table-condensed">
									<thead>
										<th>#</th>
										<th>Date</th>
										<th>Balance</th>
										<th>Principal</th>
										<th>Interest</th>
										<th>Amortization</th>
										<th>Action</th>
									</thead>
									<tbody id="loanScheduleBody">
									</tbody>
								</table>
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
						<div class="form-group">
							<input type="button" class="btn btn-danger" value="OK" id="submitpayment" name="submitpayment">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</section>

@stop

@section('scripts')

    @include('shared.scripts');

    <script>
    var token = $('meta[name="csrf-token"]').attr('content');

    $('#transaction_idmember').on('input', function() {
    	var searchKeyword = $(this).val();
    	var url = window.location+'/searchMember';

		if (searchKeyword.length >= 9) {
			// console.log(url);
			$.ajax({
	            url: ''+url,
	            type: "GET",
	            params: {_token:token},
	            data: { searchKeyword : searchKeyword },
	            success:function(data) {

	            	$.each(data, function(index, key) {
	            		console.log(data);
	            		if(data == "fail"){
	            			$("#transaction_member").val('NO DATA FOUND.');
	            			$("#transaction_idmember").val('');
		            	}else{
		            		$("#transaction_member").val(data.user_fname+' '+data.user_lname);
		            		$("#transaction_idmember").val(data.user_id);
		            	};
                   	});
	            },
	        });
		}
    });

    function getLoanDetails(){
    	var searchKeyword = $(this).val();
    	var url = window.location+'/searchLoan';
    	var member_id = $('#transaction_idmember').val();

    	if (searchKeyword.length != 0) {
			// console.log(url);
			$.ajax({
	            url: ''+url,
	            type: "GET",
	            params: {_token:token},
	            data: ({ searchKeyword : searchKeyword,
	            	member_id : member_id
	             }),
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
			    		url = window.location+"/payschedule/flatrate";
			    	}
			    	else if(method == '2'){
			    		url = window.location+"/payschedule/equalAmort";
			    	}
			    	else if(method == '3'){
			    		url = window.location+"/payschedule/equalPrincipal";
			    	}
			    	else if(method == '4'){
			    		url = window.location+"/payschedule/interestOnly";
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
				            			if(i == '5'){
				            				trHTML += '<td>'+
				            					'<input type="hidden" id="amortval" name="amortval" value="'+Number(key[i])+'">'+
				            					Number(key[i]).toLocaleString('en')+
				            					'</td>';
				            			}else{
				            				trHTML += '<td>'+Number(key[i]).toLocaleString('en')+'</td>';
				            			}
				            		}else{
				            			trHTML += '<td>'+key[i]+'</td>';
				            		}
					            }
					            trHTML += '<td><button id="paybtn" name="paybtn" class="btn btn-danger" onclick="countPayment()"><i class="fa fa-fa-plus"></i>Pay</button></td>';
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
		            		
		            		var url = window.location+"/countpayment";
		            		$.ajax({
					            url: ''+url,
					            type: "GET",
					            params: {_token:token},
					            data: ({ loan_user_id : loan_user_id,
					            		member_id : member_id
					             }),
					            
					            success:function(data) {
					            	var t = document.getElementById('loanScheduleTbl');
									var rows = t.rows; 

					            	for (var i=0; i<data; i++) {
					            		var cells = this.cells;
					            		var m = $("#paybtn").replaceWith( '<span>PAID</span>' );
					            	}
					            }
					        });
			            }
			        });

	            	
	            }
	        });
		}
    }


    function deleteRow(row){
	    var i=row.parentNode.parentNode.rowIndex;

	    if (i > 1){
	    	document.getElementById('transactionTable').deleteRow(i);
	    }else{
	    	return false;
	    }
	    
	}

	function addRow(){
		var newRowContent = '<tr><td><select id="transaction_type[]" name="transaction_type[]" class="form-control"><option value="0"></option><option value="ShareCapital">Share Capital Purchase</option><option value="OtherPayment">Other Payments</option><option value="LoanPayment">Loan Payments</option></select></td><td><input type="text" class="form-control" name="transaction_desc[]" id="transaction_desc[]"></td><td class="amountCell"><input type="text" class="form-control" name="transaction_payment[]" class="transaction_payment" id="transaction_payment[]"></td><td><button type="button" class="btn btn-danger" id="delBtn" title="Remove Transaction" onclick="deleteRow(this);"><i class="fa fa-minus"></i></button></td></tr>';
		$("#transactionTable tbody").append(newRowContent); 
	}

    </script>
@stop