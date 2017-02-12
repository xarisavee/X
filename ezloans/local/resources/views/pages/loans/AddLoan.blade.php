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
						<h2 class="page-header">LOAN <small>Create</small></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading">
								Loan Info
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6 col-lg-offset-3">
										@if(Session::has('flash_message'))
									        <div class="alert alert-success">
									            {{ Session::get('flash_message') }}
									            {{ Session::forget('flash_message') }}
									        </div>
										@elseif ($error = $errors->first('member'))
											<div class="alert alert-danger">
												{{ $error }}
											</div>
										@endif 
										<form name="newloan" method="post" action="{{ route('savenewloan', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">
											<div class="form-group">
												<label>Loan Name</label>
												<input id="loan_name" name="loan_name" class="form-control"/>
											</div>
											<div class="form-group">
												<label>Loan Description</label>
												<textarea id="loan_desc" name="loan_desc" class="form-control" rows="5" required=""></textarea>
											</div>
											<div class="form-group">
												<label>Maximum Loanable Amount</label>
												<input id="loan_maxamount" name="loan_maxamount" class="form-control"/>
											</div>
<!-- 											<div class="form-group">
												<label>Annual Interest Rate</label>
												<input id="loan_rate" name="loan_rate" class="form-control"/>
											</div> -->
											<div class="form-group">
												<label>Loan Availability</label>
												<select id="loan_availability" name="loan_availability" class="form-control">
													<option value="Always">Always</option>
													<option value="Seasonal">Seasonal</option>
												</select>
											</div>
											<div id="daterange">
												<div class="form-group">
													<label>Date Range</label>
													<!-- <input type="text" name="daterange" value="01/01/2015 - 01/31/2015" id="daterange" class="form-control"> -->
													<div class="row">
														<select id="season_start" name="season_start" class="form-controlcc">
															<?php
																for ($i = 0; $i<12; $i++) {
																	$time = strtotime(sprintf('%d months', $i));
																	$value = $i+1;
																	$label = date('F', $time);
																	printf('<option value="%s">%s</option>', $value, $label);
																}
															 ?>
														</select>
													</div>
													<div class="row">
														<select id="season_end" name="season_end" class="form-controlcc">
															<?php
																for ($i = 0; $i<12; $i++) {
																	$time = strtotime(sprintf('%d months', $i));
																	$value = $i+1;
																	$label = date('F', $time);
																	printf('<option value="%s">%s</option>', $value, $label);
																}
															 ?>
														</select>
													</div>
												</div>
											</div>
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
											<div class="form-group">
												<input class="btn btn-danger" type="submit" name="submit" value="Submit" /> 
												<input class="btn btn-default" type="reset" name="clear" value="Clear" /> 
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	@include('shared.scripts');

	<script type="text/javascript">

	$(function() {
	    $('input[name="daterange"]').daterangepicker();
	});

	$("#loan_availability").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Seasonal"){
                $("#daterange").show();
            }else{
            	$("#daterange").hide();
            }
        });
    }).change();

	$("#season_start").change(function(){
	    $(this).find("option:selected").each(function(){
	        if($(this).attr("value")=="12"){
	            $("#season_end").show();
	        }else{
	        	$("#season_end").hide();
	        }
	    });
	}).change();

	</script>
</section>

@endsection