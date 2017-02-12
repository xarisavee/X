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
						<h2 class="page-header">LOAN <small>Application</small></h2>
					</div>
				</div>
				<div class="">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading">
								Loan Application Requests
							</div>
							
							<div class="panel-body">
								<div class="box-body table-responsive">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
										@if(Session::has('flash_message'))
									        <div class="alert alert-success">
									            {{ Session::get('flash_message') }}
									            {{ Session::forget('flash_message') }}
									        </div>
										@endif 
									<table id="loanRequestTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
											<thead>
												<tr>
													<th>Loan ID</th>
													<th>Member</th>
													<th>Loan Type</th>
													<th>Amount</th>
													<th>Annual Rate</th>
													<th>Terms</th>
													<!-- <th>Standing</th> -->
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										@if(isset($loanrequestlist))
											@foreach ($loanrequestlist as $key => $data)
												<tbody>
													<tr>
														<td>{{ $data['loan_user_id'] }}</td>											
														<td>
															<table><tr>	
															<td><!-- <button type="button" class="btn btn-warning" onclick="showMemberOverview();" title="See this member's account overview"><i class="fa fa-eye"></i></button> -->
															<input type="hidden" id="memberid" name="memberid" value="{{ $data['user_id'] }}"></td>
															<td>{{ ucwords($data['user_fname']." ".$data['user_lname']) }}<t/
															</tr></table>
														</td>
														<td>{{ $data['loan_name'] }}</td>
														<td>{{ "Php ".number_format($data['loan_user_amount'], 2) }}</td>
														<td>{{ $data['loan_user_rate']."%" }}</td>
														<td>{{ $data['loan_user_terms']." ".$data['loan_user_duration'] }}</td>
														<td id="requeststatus">{{ $data['loan_request_desc'] }}</td>
														<td>
															<input type="hidden" id="loanuserid" name="loanuserid" value="{{ $data['loan_user_id'] }}">
															<button id="acceptRequest" name="acceptRequest" type="button" class="btn btn-success" onclick="acceptRequest();" title="Accept"><i class="fa fa-check"></i></button>
															<button id="rejectRequest" name="rejectRequest" type="button" class="btn btn-danger" onclick="rejectRequest();" title="Reject"><i class="fa fa-ban"></i></button>
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
			$("#loanRequestTable").DataTable();
		});

		function showMemberOverview(){
			var member_id = document.getElementById('memberid').value;
			var url = window.location+'/memberoverview/'+member_id;

			location.href=""+url;
		}

		function acceptRequest(){
			var token = $('meta[name="csrf-token"]').attr('content');
			var member_id = $("#memberid").val();
			var url = "./requests/action/"+member_id;
			var action = "2";

			var t = document.getElementById('loanRequestTable');
			var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
			for (var i=0; i<rows.length; i++) {
				rows[i].onclick = function () {
					if (this.parentNode.nodeName == 'THEAD') {
						return;
					}
					var cells = this.cells; //cells collection
					var loan_user_id = cells[0].innerHTML;
					
					// console.log(loan_user_id);
					$.ajax({
			            url: ''+url,
			            type: "GET",
			            params: {_token:token},
			            data: ({ loan_user_id : loan_user_id,
			            		 member_id : member_id,
			            		 action : action 
			            }),
			            // dataType: 'json',
			            success:function(data) {
			            	url = window.location+"/savesched/"+member_id+"/"+loan_user_id;
			            	console.log(url);
			            	if(data == "2"){
				            	$.ajax({
						            url: ""+url,
						            type: "GET",
						            params: {_token:token},
						            data: ({ loan_user_id : loan_user_id,
						            		 member_id : member_id,
						            }),
						            // dataType: 'json',
						            success:function(savedata) {
					            		$("#requeststatus").val("Accepted");
					            		location.reload();
						            }
						        });
						    }
			            }
			        });

				}
			}
		}

		/*function rejectRequest(){
			var token = $('meta[name="csrf-token"]').attr('content');
			var member_id = $("#memberid").val();
			var url = "./requests/action/"+member_id;
			var action = "3";

			var t = document.getElementById('loanRequestTable');
			var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
			for (var i=0; i<rows.length; i++) {
				rows[i].onclick = function () {
					if (this.parentNode.nodeName == 'THEAD') {
						return;
					}
					var cells = this.cells; //cells collection
					var loan_user_id = cells[0].innerHTML;
					
					console.log(loan_user_id);
					$.ajax({
			            url: ''+url,
			            type: "GET",
			            params: {_token:token},
			            data: ({ loan_user_id : loan_user_id,
			            		 member_id : member_id,
			            		 action : action 
			            }),
			            // dataType: 'json',
			            success:function(data) {

			            	if(data == "2"){
			            		$("#requeststatus").val("Accepted");
			            		location.reload();
			            	}
			            }
			        });

				}
			}
		}*/

	</script>
</section>

@endsection