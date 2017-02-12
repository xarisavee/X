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
					<h2 class="page-header">Payments <small>Loan Payments</small></h2>
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
										<button id="backbtn" type="submit" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;Back</button>
									</form>
								@endif
								<div class="row">
									<div class="col-sm-4 col-lg-4">
										<div class="form-group text-center">
											<img id="preview" src="{{ asset('images/avatar.jpeg') }}" alt="Image Preview"/>
											<input type="hidden" id="userid" name="userid" value="{{ $data['user_id'] }}">
											<input type="hidden" id="loanuserid" name="loanuserid" value="{{ $loan_user_id }}">
											<div class="col-sm-12 col-lg-12">
												<label id="profilename">{{ $data['user_fname'].' '.$data['user_lname'] }}</label>
											</div>
											<button id="startnew" class="btn btn-danger" onclick="countPayment()"><i class="fa fa-fa-plus"></i>&nbsp;Make Payment</button><br />
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
													<td>P 15,000.00 </td>
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
														<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
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

		<div id="paymentModal" name="loanSchedModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Make Payment</h4>
					</div>
					<div class="modal-body">
						<div id="makePayment" name="makePayment">
							<input type="hidden" name="paymentcount" id="paymentcount">	
							<div class="form-group">
								<label>Amount</label>
								<input type="hidden" id="paymentAmount" name="paymentAmount">
								<input type="text" class="form-controlcc" id="pay_amount" name="pay_amount">
							</div>
							<div class="form-group">
								<label>Penalty <small>(if applicable)</small></label>
								<input type="text" class="form-controlcc" id="penalty_amount" name="penalty_amount">
							</div>
							<div class="form-group">
								<input type="button" class="btn btn-danger" value="OK" id="submitpayment" name="submitpayment" onclick="checkPayment()">
							</div>
						</div>
						<div id="showReceipt" name="showReceipt">	
							
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
    $( document ).ready(function() {
   		var loan_user_id = document.getElementById('loanuserid').value;
		var member_id = document.getElementById('userid').value;
		var url = window.location+"/payschedule";
		var token = $('meta[name="csrf-token"]').attr('content');
		console.log(url);
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
	});

		$(function () {
			$("#adminsTable").DataTable();
			$("#memberloanstable").DataTable();
			$("#treasurerTable").DataTable();
			$("#membersTable").DataTable();
		});

		function applyLoan(){
			var userid = document.getElementById('userid').value;
			// alert(code);
			location.href="../apply/"+userid;
		}

		function showSchedule(){
			
		}

		function countPayment(){
			var loan_user_id = document.getElementById('loanuserid').value;
			var member_id = document.getElementById('userid').value;
			var token = $('meta[name="csrf-token"]').attr('content');
			var url = window.location+"/countpayment";

			var t = document.getElementById('loanScheduleTbl');
			var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
			for (var i=0; i<rows.length; i++) {
				rows[i].onclick = function () {
					if (this.parentNode.nodeName == 'THEAD') {
						return;
					}
					var cells = this.cells; //cells collection
					// var m1V = $(this).closest('tr').find('input[name="amortval"]').val();
					var amt = parseFloat($(this).closest('tr').find('input[name="amortval"]').val());
					$('#paymentAmount').val(amt);
					// console.log(this);
				}
			}

			$.ajax({
	            url: ''+url,
	            type: "GET",
	            params: {_token:token},
	            data: ({ loan_user_id : loan_user_id,
	            		member_id : member_id
	             }),
	            
	            success:function(data) {
	            	$("#paymentcount").val(parseInt(data));
	            	// console.log(data);
	            	jQuery("#paymentModal").modal('show');	
	            }
	        });
		}

		function checkPayment(){
			var paymentAmount = document.getElementById('paymentAmount').value;
			var pay_amount = document.getElementById('pay_amount').value;
			var penalty = document.getElementById('penalty_amount').value;
			var loan_user_id = document.getElementById('loanuserid').value;
			var member_id = document.getElementById('userid').value;
			var token = $('meta[name="csrf-token"]').attr('content');
			var url = window.location+"/countpayment";

			var payment = parseFloat(pay_amount);
			var needpay = parseFloat(paymentAmount);
			var change = 0;

			if(payment > needpay){
				change = payment-needpay;
			}else{
				change = 0;
			}
				
			var Receipt = '';
			Receipt += '<input type="hidden" id="paidamount" name="paidamount"><div class="form-group"><label id="changeAmount">Change Amount</label><input type="text" class="form-controlcc" id="change_amount" name="change_amount"></div>';
			
			$("#showReceipt").empty();
			$("#showReceipt").append(Receipt);
			$("#paidamount").val(needpay);
			$("#change_amount").val(change);
	        
	        var url = window.location+'/makePayment';
        	var payment_amount = parseFloat( document.getElementById('paidamount').value );
        	var payment_count = parseInt( document.getElementById('paymentcount').value );
        	// console.log(payment_amount);

        	$.ajax({
	            url: ''+url,
	            type: "GET",
	            params: {_token:token},
	            data: ({ loan_user_id : loan_user_id,
	            		member_id : member_id,
	            		payment_amount : payment_amount
	             }),
	            
	            success:function(payment) {
	            	var t = document.getElementById('loanScheduleTbl');
					var rows = t.rows; 

					if(payment == 1){
						for (var i=0; i<payment_count+1; i++) {
		            		var cells = this.cells;
		            		var m = $("#paybtn").replaceWith( '<span>PAID</span>' );
		            	}
		            	location.reload();
					}else{
						return false;
					}   	  	
	            }
	        }); 
		}

    </script>
@stop