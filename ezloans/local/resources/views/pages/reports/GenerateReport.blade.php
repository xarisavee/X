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
						<h1 class="page-header">Generate Report</h1>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							Select Date Range of Reports
						</div>
						<div class="panel-body">
							<div class="form-group">
								<form action="reports.php?action=vieweteeapreports" method="post">
									<div class="col-lg-6 col-lg-offset-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="date" class="form-control"  id="evstart" name="evstart">
										</div>
										<div class="form-group">
											<label>End Date</label>
											<input type="date" class="form-control"  id="evend" name="evend">
										</div>
										<div>
											<input type="submit" class="btn btn-danger"  value="Generate">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	@include('shared.datatablescript');

</section>

@endsection