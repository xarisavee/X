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
                   <h2 class="page-header">MEMBER <small>Overview</small></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            Member Masterlist
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
														<th class="col-lg-3">Actions</th>
													</tr>
												</thead>

											@if(isset($memberlist))
											@foreach ($memberlist as $key => $data)
											<tbody>
													<tr>
														<td>{{ $data['user_id'] }}</td>
														<td>{{ ucwords($data['user_lname'].", ".$data['user_fname']) }}</td>
														<td> 
															<input type="hidden" value="">
															@if($checkLoans!=0)
															<button type="button" class="btn btn-warning" onclick="viewLoanBook();" title="Loan Book"><i class="fa fa-book"></i></button>
															@else
															<button type="button" class="btn btn-warning" onclick="viewLoanBook();" disabled="" title="Add a loan type to enable loan books"><i class="fa fa-book"></i></button>
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
</section>

@stop

@section('scripts')
    @include('shared.scripts');

    <script>
	$(function () {
		$("#memberTable").DataTable();
	});
	
	function viewLoanBook() {
		var t = document.getElementById('memberTable');
		var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
		for (var i=0; i<rows.length; i++) {
			rows[i].onclick = function () {
				if (this.parentNode.nodeName == 'THEAD') {
					return;
				}
				var cells = this.cells; //cells collection
				var member_id = cells[0].innerHTML;
				var url = window.location+"/"+member_id;
				location.href = url;
			}
		}
	}

    </script>

@stop