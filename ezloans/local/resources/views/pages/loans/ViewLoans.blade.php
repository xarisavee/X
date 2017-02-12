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
				<div class="">
					<div class="col-lg-12">
						<h2 class="page-header">LOAN <small>Overview</small></h2>
					</div>
				</div>
				<div class="">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading">
								Types of Loan
							</div>
							
							<div class="panel-body">
								<div class="box-body table-responsive">
										@if(Session::has('flash_message'))
									        <div class="alert alert-success">
									            {{ Session::get('flash_message') }}
									            {{ Session::forget('flash_message') }}
									        </div>
										@endif 
									<table id="loansTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
											<thead>
												<tr>
													<th>Loan Name</th>
													<th>Maximum Loanable</th>
													<th>Loan Status</th>
													<th>Loan Availability</th>
													<th>Actions</th>
												</tr>
											</thead>
										@if(isset($loanlist))
											@foreach ($loanlist as $key => $data)
												<tbody>
													<tr>														
														<td><input type="hidden" value="{{$data['loan_id']}}" id="loanid" name="loadid">{{ ucwords($data['loan_name']) }}</td>
														<td>{{ "Php ".number_format($data['loan_maxamount'], 2) }}</td>
														<td> @if($data['loan_status']=="1") {{ ("Active") }} @endif</td>
														<td>@if($data['loan_season_start']!="" AND $data['loan_season_end'] != "")
																{{ date('M', mktime(0, 0, 0, $data['loan_season_start'], 1))." - ".date('M', mktime(0, 0, 0, $data['loan_season_end'], 1)) }}
															@else
																{{ "Always" }}
															@endif
														</td>
														<td> 
															<button type="button" class="btn btn-info" onclick="updateLoan()" title="Edit this loan's settings"><i class="fa fa-check-square-o"></i></button>&nbsp;
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

	@include('shared.scripts');
	<script>
		$(function () {
			$("#loansTable").DataTable();
		});

		$('div.alert').not('.alert-important').delay(5000).slideUp(300);

		function updateLoan(){
			var code = document.getElementById('loanid').value;
			// alert(code);
			location.href="../loan/"+code;
		}
	</script>
</section>

@endsection