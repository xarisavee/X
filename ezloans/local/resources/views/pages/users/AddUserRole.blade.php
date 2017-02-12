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
					<h2 class="page-header">User <small>Overview</small></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel">
						<form name="addtut" action="tutors.php?action=savingnewtutor" method="post">
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
		                        	<a class="btn btn-primary" href="" title="Add User"><i class="fa fa-plus fa-fw"></i></a>
		                        </div>
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>

@stop

@section('scripts')

    @include('shared.scripts');

	<script>
	 $("#memberTable").dataTable();

    </script>
@stop