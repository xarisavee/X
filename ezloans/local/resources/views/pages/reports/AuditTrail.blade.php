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
						<h1 class="page-header">Audit Trail</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading">
								Audit Trail
							</div>
							<div class="panel-body">
								<div class="box-body table-responsive">					
									<table id="actTable" class="table table-bordered table-hover text-center table-condensed">
										<thead>
											<tr>
												<th>Time</th>
												<th>Date</th>
												<th>User</th>
												<th>Activity</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>he</td>
												<td>he</td>
												<td>he</td>
												<td>he</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	@include('shared.datatablescript');

</section>

@endsection