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
					<h2 class="page-header">User <small></small></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							System Users
						</div>
						<div class="panel-body">
							<div class="col-sm-12 col-lg-12 col-lg-offset-2">
								<div class="row" id="rolediv">
									Everyone who works on your system can have a different role depending on what they need to work on. <strong><a href="#" data-toggle="modal" data-target="#roleInfoModal">Learn More.</a></strong>
								</div>
								<input type="hidden" value="{{ $user_id }}">
							</div>
							<br />
							<div class="row" id="RoleManagement">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" id="adminTab" href="#Authorized">Authorized Personnel</a></li>
									<!-- <li><a data-toggle="tab" id="secretaryTab" href="#Secretary">Secretary</a></li> -->
									<!-- <li><a data-toggle="tab" id="treasurerTab" href="#Treasurer">Treasurer</a></li> -->
									<li><a data-toggle="tab" id="regMemberTab" href="#RegMembers">Regular Members</a></li>
								</ul>

								<div class="tab-content">
									<div id="Authorized" class="tab-pane fade in active">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<table id="adminsTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
														<thead>
															<tr>
																<th class="col-lg-3">ID Number</th>
																<th class="col-lg-6">Name</th>
																<th class="col-lg-3">Role</th>
															</tr>
														</thead>

														@if( isset($authorized) AND is_array($authorized) )
															@foreach( $authorized as $auth )
																<tbody>
																	<tr>
																		<td>{{ $auth['user_id'] }}</td>
																		<td>{{ ucwords( $auth['user_fname']." ".$auth['user_lname'] ) }}</td>
																		<td>
																			{{ ucwords($auth['role_desc']) }}
																		</td>
																	</tr>
																</tbody>
																@endforeach
														@else
															<tbody>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
															</tbody>
														@endif
													</table>
												</div>
											</div>	
										</div>
									</div>

 									<!-- <div id="Secretary" class="tab-pane fade in">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<table id="adminsTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
														<thead>
															<tr>
																<th class="col-lg-3">ID Number</th>
																<th class="col-lg-6">Name</th>
																<th class="col-lg-3">Role</th>
															</tr>
														</thead>

														@if( isset($authorized) AND is_array($authorized) )
															@foreach( $authorized as $auth )
																<tbody>
																	<tr>
																		<td>{{ $auth['user_id'] }}</td>
																		<td>{{ ucwords( $auth['user_fname']." ".$auth['user_lname'] ) }}</td>
																		<td>
																			{{ ucwords($auth['role_desc']) }}
																		</td>
																	</tr>
																</tbody>
																@endforeach
														@else
															<tbody>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
															</tbody>
														@endif
													</table>
												</div>
											</div>	
										</div>
									</div>

									<div id="Treasurer" class="tab-pane fade in">
										<div class="col-sm-12 col-lg-12 col-lg-offset-0">
											<div class="row">
												<div class="resultarea">
													<table id="adminsTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
														<thead>
															<tr>
																<th class="col-lg-3">ID Number</th>
																<th class="col-lg-6">Name</th>
																<th class="col-lg-3">Role</th>
															</tr>
														</thead>

														@if( isset($authorized) AND is_array($authorized) )
															@foreach( $authorized as $auth )
																<tbody>
																	<tr>
																		<td>{{ $auth['user_id'] }}</td>
																		<td>{{ ucwords( $auth['user_fname']." ".$auth['user_lname'] ) }}</td>
																		<td>
																			{{ ucwords($auth['role_desc']) }}
																		</td>
																	</tr>
																</tbody>
																@endforeach
														@else
															<tbody>
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
															</tbody>
														@endif
													</table>
												</div>
											</div>	
										</div>
									</div> -->

									<div id="RegMembers" class="tab-pane fade in">
										<form id="changeRoleForm" action="{{ route('savenewrole', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" method="post">
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
											<br />
											<div class="col-sm-12 col-lg-12 col-lg-offset-0">
												<div class="row">
													<div class="resultarea">
														<table id="membersTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
															<thead>
																<tr>
																	<th class="col-lg-3">ID Number</th>
																	<th class="col-lg-6">Name</th>
																	<th class="col-lg-3">Role</th>
																</tr>
															</thead>

															@if(isset($unauthorized) AND is_array($unauthorized))
																@foreach ($unauthorized as $key => $data)
																<tbody>
																	<tr>
																		<td>
																			<input name="idFlag[]" id="idFlag[]" type="hidden" value="{{ $data['user_id'] }}">{{ $data['user_id'] }}
																			<input type="hidden" name="emailFlag[]" id="emailFlag[]" value="{{ $data['user_email'] }}"></td>
																		<td>{{ ucwords($data['user_lname'].", ".$data['user_fname']) }}</td>
																		<td>
																			<select id="roleselect[]" name="roleselect[]" class="form-control">
																				@if(isset($roles))
																				<option value="6">Member</option>
																				@foreach($roles as $role)
																					<option value="{{ $role['role_id'] }}">{{ $role['role_desc']}}</option>
																				@endforeach
																				@endif
																			</select>
																		</td>
																	</tr>
																</tbody>
																@endforeach
															@else
															<tbody>
																<tr>
																	<td></td>
																	<td></td>
																	<td></td>
																</tr>
															</tbody>
															@endif
														</table>
														<div class="col-lg-12 text-center btnbreak">
															<div>
																<input class="btn btn-danger" type="submit" id="rolesubmit" name="rolesubmit" value="Save Changes" disabled="" /> 
																<input class="btn btn-primary" type="reset" name="clear" onclick="disableSubmit()"value="Clear" /> 
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
			</div>
		</div>
    </div>

	<div class="modal fade" id="roleInfoModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="roleModalLabel">What are the different system roles and what can they do?</h4>
				</div>
				<div class="modal-body">

				</div>
			</div>
		</div>
	</div>

</section>

@stop

@section('scripts')

    @include('shared.scripts');

    <script>

		$(function () {
			$("#adminsTable").DataTable();
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

    </script>
@stop