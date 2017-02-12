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
						<!-- <form name="addtut" action="tutors.php?action=savingnewtutor" method="post">
							<div class="panel-heading">
								System Users
							</div>
	                        <div class="panel-body">
	                            <div class="row">
		                            <div class="col-lg-12">
		                                <div class="box-body table-responsive">					
												<table id="memberTable" class="table table-bordered table-hover text-center table-condensed">
													<thead>
														<tr>
															<th class="col-lg-3">ID Number</th>
															<th class="col-lg-6">Name</th>
															<th class="col-lg-3">Role</th>
															<th class="col-lg-3">Action</th>
														</tr>
													</thead>

												@if(isset($userinfo))
												@foreach ($userinfo as $key => $data)
												<tbody>
														<tr>
															<td>{{ $data['user_id'] }}</td>
															<td>{{ ucwords($data['user_lname'].", ".$data['user_fname']) }}</td>
															<td>
															<td></td>
																<input type="hidden" value="">
																<button type="button" class="btn btn-info" data-toggle="modal" data-target="#employeeModal"><i class="fa fa-check-square-o"></i></button>&nbsp;
																<button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
															</td>
														</tr>
												</tbody>
												@endforeach
												@endif
											</table>
										</div>
		                            </div>
		                        </div>
		                        <div class="smalldivbreak">
		                        	<a id="adduserbtn" class="btn btn-danger pull-right" href="" title="Add User">
		                        		<i class="fa fa-plus fa-fw"></i>
		                        	</a>
		                        </div>
	                        </div>
						</form> -->

						<div class="panel-heading">
							System Users
						</div>
						<div class="panel-body">
							<div class="col-sm-12 col-lg-12 col-lg-offset-2">
								<div id="rolediv text-center">
									Everyone who works on your Page can have a different role depending on what they need to work on. <strong><a href="#" data-toggle="modal" data-target="#roleInfoModal">Learn More.</a></strong>
								</div>
								<input type="hidden" value="{{ $user_id }}">
							</div>

							<div class="col-sm-12 col-lg-8 col-lg-offset-2">
								<div class="row">
									<form method="post" action="">
										<div id="searcharea" class="input-group">
											<input type="text" id="searchbox" name="searchbox" class="form-control" placeholder="Search by name, email, or ID number">
											<div class="input-group-btn">
												<button class="btn btn-default" type="submit">
													<i class="glyphicon glyphicon-search"></i>
												</button>
											</div>
										</div>
										<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
									</form>
								</div>	
							</div>

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

											@if( isset($admins) )
												@foreach( $admins as $auth )
													<tbody>
														<tr>
															<td>{{ $auth['user_id'] }}</td>
															<td>{{ ucwords( $auth['user_fullname'] ) }}</td>
															<td>
																<button type="button" class="btn btn-info" data-toggle="modal" data-target="#employeeModal" title="Admin"><i class="fa fa-check-square-o"></i></button>
															</td>
														</tr>
													</tbody>
													@endforeach
											@endif


										</table>
									</div>
								</div>	
							</div>

							<div class="col-sm-12 col-lg-12 col-lg-offset-0">
								<div class="row">
									<div class="resultarea">
										<table id="secretaryTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
											<thead>
												<tr>
													<th class="col-lg-3">ID Number</th>
													<th class="col-lg-6">Name</th>
													<th class="col-lg-3">Role</th>
												</tr>
											</thead>

											@if( isset($secretary) )
												@foreach( $secretary as $auth )
													<tbody>
														<tr>
															<td>{{ $auth['user_id'] }}</td>
															<td>{{ ucwords( $auth['user_fullname'] ) }}</td>
															<td>
																<button type="button" class="btn btn-info" data-toggle="modal" data-target="#employeeModal" title="Secretary"><i class="fa fa-check-square-o"></i></button>
															</td>
														</tr>
													</tbody>
													@endforeach
											@endif


										</table>
									</div>
								</div>	
							</div>
							<div class="col-sm-12 col-lg-12 col-lg-offset-0">
								<div class="row">
									<div class="resultarea">
										<table id="treasurerTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
											<thead>
												<tr>
													<th class="col-lg-3">ID Number</th>
													<th class="col-lg-6">Name</th>
													<th class="col-lg-3">Role</th>
												</tr>
											</thead>

											@if( isset($treasurer) )
												@foreach( $treasurer as $auth )
													<tbody>
														<tr>
															<td>{{ $auth['user_id'] }}</td>
															<td>{{ ucwords( $auth['user_fullname'] ) }}</td>
															<td>
																<button type="button" class="btn btn-info" data-toggle="modal" data-target="#employeeModal" title="Treasurer"><i class="fa fa-check-square-o"></i></button>
															</td>
														</tr>
													</tbody>
													@endforeach
											@endif


										</table>
									</div>
								</div>	
							</div>

							<div class="col-sm-12 col-lg-12 col-lg-offset-0">
								<div class="row">
									<div class="resultarea">
										<table id="roleTable" class="table table-responsive table-bordered table-hover text-center table-condensed">
											<thead>
												<tr>
													<th class="col-lg-3">ID Number</th>
													<th class="col-lg-6">Name</th>
													<th class="col-lg-3">Role</th>
												</tr>
											</thead>

											@if(isset($regularmembers))
												@foreach ($regularmembers as $key => $data)
												<tbody>
													<tr>
														<td>{{ $data['user_id'] }}</td>
														<td>{{ ucwords($data['user_lname'].", ".$data['user_fname']) }}</td>
														<td>
															@if($data['role_id']=='5')
															<button type="button" class="btn btn-info" data-toggle="modal" data-target="#employeeModal" title="{{ $data['role_desc'] }}"><i class="fa fa-check-square-o"></i></button>
															@endif

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
		$("#adminTable").dataTable();
		$("#secretaryTable").dataTable();
		$("#treasurerTable").dataTable();
		$("#roleTable").dataTable();
		

    </script>
@stop