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
					<h2 class="page-header">LOAN <small>Apply New</small></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							Loan Application
						</div>
						<div class="panel-body">
							@if(isset($memberprofile) AND (!empty($memberprofile)))
							@foreach($memberprofile as $key => $data)
							<div id="userprofile">
								<div class="row">
									<input type="hidden" value="{{ $user_id }}">
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
													<th>Total Share Capital:</i></th>
													<td>P {{ number_format($totalshare) }}</td>
												</tr>
											</table>
										</div>
									</div>							
								</div>
							</div>
							@endforeach
							@endif

							<form method="get" action="{{ route('applynew_comakers', array('domain' => $domain, 'user_id' => $userinfo['user_id'], 'member_id' => $member_id)) }}">
								<div class="row">
									<input type="hidden" id="loanid" name="loanid">
									<input type="hidden" id="memberid" name="memberid" value="{{ $member_id }}">
									
									<div class="col-md-6 col-lg-6 div2break">	
										<div class="form-group">
											<div class="row smalldivbreak">
												<h5>LOAN</h5>
												<div class="col-lg-8">
													<label for="loantype">Loan Type</label>
													<select class="form-control" id="loantype" name="loantype">
														<option value="">-- Select Loan Type --</option>
														@if(isset($seasons))
														@foreach($seasons as $list)
															<option value="{{ $list['loan_id'] }}"> {{ $list['loan_name'] }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<fieldset id="disableFields" name="disableFields" disabled="disabled">
											<div class="row smalldivbreak">
												<h5>PRINCIPAL</h5>
												<div class="col-lg-8">
													<div class="form-group">
														<label>Disbursement Method</label>
														<select class="form-control" id="disbursement" name="disbursement">
															<option value="Cash">Cash</option>
															<option value="Cheque">Cheque</option>
															<option value="Bank Transfer">Bank Transfer</option>
														</select>
													</div>
													<div class="form-group">	
														<label>Loan Amount</label>
														<div class="input-group">
															<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-rouble fa-lg fa-inverse"></i></span>
															<input type="text" id="amount" name="amount" class="form-control" onkeydown="return numericOnly(event);" onblur=" return checkAmount('amount');" onfocus="return clearField('amount');" required="">
														</div>
														<div id="editAmount" name="editAmount">
															<div class="alert alert-danger" id="amountError">
															</div>
														</div>
													</div>
													<div class="form-group">	
														<label>Release Date</label>
														<input type="date" id="releasedate" name="releasedate" class="form-control">
													</div>
												</div>
											</div>

											<div class="row smalldivbreak">
												<h5>INTEREST</h5>
												<div class="col-lg-8">
													<div class="form-group">
														<label>Method of Interest</label>
														<select id="interest_method" name="interest_method" class="form-control">
															@if(isset($interestmethod))
															@foreach($interestmethod as $method)
																<option value="{{ $method['int_method_id'] }}"> {{ $method['int_method_name'] }}</option>
															@endforeach
															@endif
														</select>
													</div>
													<div class="form-group">	
														<label>Annual Interest Rate</label>
														<div class="input-group">
															<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-percent fa-lg fa-inverse"></i></span>
															<input id="rate" name="rate" class="form-control" required="" />
														</div>
													</div>
													<div class="form-group">	
														<label>Compounding Period<small>(optional)</small></label>
														<select id="interest_accumulation" name="interest_accumulation" class="form-control">
															<option value="Default"></option>
															<option value="Daily">Daily</option>
															<option value="Weekly">Weekly</option>
															<option value="Biweekly">Biweekly</option>
															<option value="Monthly">Monthly</option>
															<option value="Bimonthly">Bimonthly</option>
															<option value="Quarterly">Quarterly</option>
															<option value="Semi-annually">Semi-annually</option>
															<option value="Annually">Annually</option>
															<option value="Continuous">Continuous</option>
														</select>
													</div>
												</div>
											</div>

											<div class="row smalldivbreak">
												<h5>DURATION</h5>
												<div class="col-lg-8">
													<div class="form-group">
														<label>Terms</label>
														<div class="input-group">
															<input class="form-control" type="text" id="terms" name="terms" onkeydown="return numericOnly(event);" onblur="checkTerms(); required">
															<select id="duration" name="duration" class="form-control">
																<option value=""></option>
																<option value="Months">Months</option>
																<option value="Years">Years</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label>Payment Frequency</label>
														<select id="repayment_type" name="repayment_type" class="form-control">
															<option value=""></option>
															<option value="Daily">Daily</option>
															<option value="Weekly">Weekly</option>
															<option value="Biweekly">Biweekly</option>
															<option value="Monthly" selected="">Monthly</option>
															<option value="Bimonthly">Bimonthly</option>
															<option value="Quarterly">Quarterly</option>
															<option value="Semi-annually">Semi-annually</option>
															<option value="Annually">Annually</option>
														</select>
													</div>
												</div>
											</div>

											<div class="row smalldivbreak">
												<h5>OTHER FEES</h5>
												<div class="col-lg-8">
													<div class="form-group">
														<label>Processing Fee</label>
														<input id="processing" name="processing" class="form-control" onkeydown="return numericOnly(event);" />
													</div>
													<div class="form-group">
														<label>Retention Fee (percentage from amount borrowed)</label>
														<input id=retention name=retention class="form-control" onkeydown="return numericOnly(event);" />
													</div>
												</div>
											</div>

											<div class="row smalldivbreak">
												<div class="form-group text-center">
													<input class="btn btn-danger" type="button" name="calculate" onclick="calculateLoan();" value="Calculate" /> 
													<!-- <input class="btn btn-danger" type="submit" name="calculate" value="Calculate" />  -->
													<input class="btn btn-primary" type="reset" name="clear" value="Reset" onClick="window.location.reload()"/> 
												</div>
											</div>
											</fieldset>
										</div>	
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div id="results">
											<div id="loanSchedule">
												<div class="form-group">
													<table class="table table-responsive table-hover table-bordered table-bordered table-condensed">
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
												<div class="form-group">
													<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
													<input class="btn btn-danger" type="submit" name="apply" id="apply" value="Apply Loan" /> 
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
	</div>


	@include('shared.scripts');

	<script type="text/javascript">

	$(document).ready(function(){
		$("#editAmount").hide();
		$("#loanSchedule").hide();

	});

	var cTermstart; //check terms
	var cTermend;
	var maxAmount;

	$("#loantype").change(function(){
        var loanID = $(this).val();
        var url = window.location+'/getLoanDetails/'+loanID;
        if(loanID) {
            $.ajax({
                url: ''+url,
                type: "GET",
                data: "",
                dataType: 'json',
                success:function(data) {
 
                    $.each(data, function(index, key) {
                        // $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        // $("#rate").val(key.loan_rate_value);
                        $("#loanid").val(key.loan_id);
                        maxAmount = parseInt(key.loan_maxamount, 10);
                        console.log(url);
                    });

                }
            });
        }else{
            console.log('error');
        }

		$("#disableFields").prop("disabled", false);
    });

    function checkTerms(){

    }

    $.fn.digits = function(){ 
	    return this.each(function(){ 
	        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
	    })
	}

    function checkAmount(amount){
    	var iamount = $("#amount").val();
    	var amount = document.getElementById(amount);
		var goodColor = "#66cc66";
		var badColor = "#a94442";

		if($("#amount").val().length > 0){
			console.log($("#amount").val().length);
			console.log("Max: "+maxAmount);

			Amount = maxAmount;

			if (iamount <= Amount){
	    		amount.style.borderColor = goodColor;
	    		$("#amountError").text("");
	    		$("#editAmount").hide();
	    		// console.log("HEY "+iamount);
	    		
	    	}else{
	    		amount.style.borderColor = badColor;
	    		$("#amountError").text("Amount exceeds maximum loanable amount. MAX: P"+Number(maxAmount).toLocaleString('en'));
	    		$("#editAmount").show();    		
	    		$("#amount").val("");
	    		// console.log("HEY "+Amount);
	    	}
		}else{
			$("#amount").val("");
			$("#amountError").text("");
			$("#editAmount").hide(); 
		}
    	
    }

    function clearField(field){
    	$("#amountError").text("");
		$("#editAmount").hide(); 
		$("#amount").val("");
    	console.log(field);
    }

    function calculateLoan(){
    	var token = $('meta[name="csrf-token"]').attr('content');

    	var loanID = $("#loanid").val();

    	var method = $("#interest_method").val();
    	var url = "";
    	if(method == '1'){
    		url = window.location+'/flatrate/'+loanID;
    	}
    	else if(method == '2'){
    		url = window.location+'/equalAmort/'+loanID;
    	}
    	else if(method == '3'){
    		url = window.location+'/equalPrincipal/'+loanID;
    	}
    	else if(method == '4'){
    		url = window.location+'/interestOnly/'+loanID;
    	}
    	else{
    		url = window.location;
    	}

    	
    	var Amount = parseFloat($("#amount").val());
    	var Rate = parseFloat($("#rate").val());
    	var RetentionFee = parseFloat($("#retention").val());
    	var ProcessingFee = parseFloat($("#processing").val());
    	
    	var ReleaseDate = $("#releasedate").val();

    	var InterestMethod = $("#interest_method").val();
    	var Accumulation = $("#interest_accumulation").val();

    	var Terms = $("#terms").val();
    	var Duration = $("#duration").val();

    	var Repayment = $("#repayment_type").val();
    	// var RepaymentCount = parseInt($("#repayment_count").val());

    	var AnnualRate = 0;
	    var MonthlyRate = 0;
	    var LoanInstallment = 0;
	    var retentionValue = 0;
	    var NetLoanable = 0;

    	AnnualRate = Rate;
		MonthlyRate = AnnualRate/12;
		DecimalMonthlyRate = MonthlyRate/100;

		// LoanInstallment = (DecimalMonthlyRate*Amount) / (1 - Math.pow((1+DecimalMonthlyRate), -Math.abs(Terms)));
	    // LoanInstallment = LoanInstallment.toFixed(2);
	    retentionValue = (Rate/100) * Amount;
	    processingValue = ProcessingFee;
	    totalDeduct = retentionValue + processingValue;
	    NetLoanable = Amount - totalDeduct;

	    // console.log("Method "+InterestMethod);
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
            success:function(data) {

            	var trHTML = '';

            	$.each(data, function(index, key) {
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

            	$('#loanScheduleBody').empty();
            	$('#loanScheduleBody').append(trHTML);	
            	console.log(data);
            }
        });

        $("#retVal").text("Php "+Number(retentionValue).toLocaleString('en'));
	    $("#procVal").text("Php "+Number(processingValue).toLocaleString('en'));
	    $("#totalDeduction").text("Php "+Number(totalDeduct.toFixed(2)).toLocaleString('en'));
	    $("#netLoan").text("Php "+Number(NetLoanable.toFixed(2)).toLocaleString('en'));
	    $("#loanSchedule").show();


    }

	</script>
</section>

@endsection