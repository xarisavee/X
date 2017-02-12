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

							<div class="row">
								<div id="LoanBook">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" id="loansTab" href="#ActiveLoans">Active Loans</a></li>
										<li><a data-toggle="tab" id="loansTab" href="#AllLoans">All Loans</a></li>
										<!-- <li><a data-toggle="tab" id="sharecapitalTab" href="#ShareCapital">Share Capital</a></li> -->
									</ul>

									<div class="tab-content">
										<div id="ActiveLoans" class="tab-pane fade in active">
											<div class="col-sm-12 col-lg-12 col-lg-offset-0">
												<div class="row">
													<div class="resultarea">
														<table id="activeloanstable" class="table table-responsive table-bordered table-hover text-center table-condensed">
															<thead>
																<tr>
																	<th>Loan ID</th>
																	<th>Loan Type</th>
																	<th>Amount</th>
																	<th>Interest Rate</th>
																	<th>Terms</th>
																	<!-- <th>Amortization</th> -->
																	<th>Start - End Date</th>
																	<th>Schedule</th>
																</tr>
															</thead>
															@if(isset($memberloans))
															@foreach($memberloans as $loans => $data)
															<tbody>
																<tr>
																	<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
																	<td>{{ $data['loan_user_id'] }}</td>
																	<td>{{ ucwords($data['loan_name']) }}</td>
																	<td>{{ "Php ".number_format($data['loan_user_amount']) }}</td>
																	<td>{{ $data['loan_user_rate']."%" }}</td>
																	<td>{{ $data['loan_user_terms']." ".$data['loan_user_duration'] }}</td>
																	<!-- <td>{{ "Php ".number_format($data['loan_user_amortization']) }}</td> -->
																	<td>{{ $data['loan_user_termstart']." - ".$data['loan_user_termend'] }}</td>
																	<td>
																		<button type="button" class="btn btn-warning" onclick="showSchedule()" title="See more about this loan."><i class="fa fa-calendar-o"></i></button>&nbsp;
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

										<div id="AllLoans" class="tab-pane fade in">
											<div class="col-sm-12 col-lg-12 col-lg-offset-0">
												<div class="row">
													<div class="resultarea">
														<table id="allloanstable" class="table table-responsive table-bordered table-hover text-center table-condensed">
															<thead>
																<tr>
																	<th>Loan ID</th>
																	<th>Loan Type</th>
																	<th>Amount</th>
																	<th>Interest Rate</th>
																	<th>Terms</th>
																	<!-- <th>Amortization</th> -->
																	<th>Start - End Date</th>
																	<th>Status</th>
																	<!-- <th>Schedule</th> -->
																</tr>
															</thead>
															@if(isset($memberloans))
															@foreach($memberloans as $loans => $data)
															<tbody>
																<tr>
																	<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
																	<td>{{ $data['loan_user_id'] }}</td>
																	<td>{{ ucwords($data['loan_name']) }}</td>
																	<td>{{ "Php ".number_format($data['loan_user_amount']) }}</td>
																	<td>{{ $data['loan_user_rate']."%" }}</td>
																	<td>{{ $data['loan_user_terms']." ".$data['loan_user_duration'] }}</td>
																	<!-- <td>{{ "Php ".number_format($data['loan_user_amortization']) }}</td> -->
																	<td>{{ $data['loan_user_termstart']." - ".$data['loan_user_termend'] }}</td>
																	<td>{{ ucwords($data['loan_request_desc']) }}</td>
																	<!-- <td>
																		<button type="button" class="btn btn-warning" onclick="showSchedule()" title="See more about this loan."><i class="fa fa-calendar-o"></i></button>&nbsp;
																	</td> -->
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
			var t = document.getElementById('activeloanstable');
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