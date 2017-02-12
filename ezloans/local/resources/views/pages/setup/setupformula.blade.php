@extends('layouts.setuplayout')

@section('setupcontent')
	<div id="page-wrappersign">
	    <div id="centersign" class="panel">
	        <div class="panel-heading">
	        	System Features Setup
	        </div>
			<div class="panel">
				<div class="panel-body">
		          	<div class="row">
		            	<div class="col-lg-10 col-lg-offset-1">
							<div class="divbreak">
							    <br />
							    <h4><strong>Loan Calculator</strong></h4>
							    <p>The system will use the standard loan formula. (There are other formats of this formula but also produces the same output.)</p>
						        <div>
						        	<form id="Formula1Form" action="" method="post">
										<br />
										<img class="img-responsive center-block" src="{{ asset('images/formula/formula1.png') }}" height="230px" width="230px" alt="P= r(PV) / 1 - (1+r)^-n" />
										<br />
										<br />
										<br />
										<label>Annual Rate</label>
										<div class="form-group input-group col-xs-6">
											<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-percent fa-lg fa-inverse"></i></span>
											<input class="form-control" type="text" id="f1_r" name="f1_r" >
										</div>

										<label>Loan Amount</label>
										<div class="form-group input-group col-xs-6">
											<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-rub fa-lg fa-inverse"></i></span>
											<input class="form-control" type="text" id="f1_pv" name="f1_pv" >
										</div>

										<label>Terms (in years)</label>
										<div class="form-group input-group col-xs-8">
											<span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-calendar fa-lg fa-inverse"></i></span>
											<input class="form-control" type="text" id="f1_n" name="f1_n" >
											<span class="input-group-addon"></span>
											<select id="Term_Multiplier1" class="form-control" type="text" name="Term_Multiplier">
												<option value="months">months</option>
												<option value="years">years</option>
											</select>
										</div>

										<strong><h4 id="Formula1Output"></h4></strong>
										<div class="form-group input-group">
											<button class="form-control" type="button"  onclick="Formula1Calc();" value="Calculate">Calculate</button>
											<button class="form-control" type="reset" value="Reset" onclick="resetAll();">Reset</button>
										</div>
									</form>
								</div>
		            		</div>
		          		</div>
		          		<div class="col-lg-6">
			          		<form method="post" action="">	
			          			<input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}">		
								<input class="form-control btn btn-danger" type="submit" value="Setup Complete">
							</form>
						</div>
		        	</div>
				</div>
	    	</div>
		</div>
	</div>




	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){

		var divobj = document.getElementById('Formula1Output');
	    divobj.style.display='none';

	    $("select[id='formulaselect']").change(function(){
	        $(this).find("option:selected").each(function(){
	            if($(this).attr("value")=="formula1"){
	                $(".box").not(".formula1").hide();
	                $(".formula1").show();
	            }
	            else if($(this).attr("value")=="formula2"){
	                $(".box").not(".formula2").hide();
	                $(".formula2").show();
	            }
	            else if($(this).attr("value")=="formula3"){
	                $(".box").not(".formula3").hide();
	                $(".formula3").show();
	            }
	            else if($(this).attr("value")=="formula4"){
	                $(".box").not(".formula4").hide();
	                $(".formula4").show();
	            }
	            else{
	                $(".box").hide();
	            }
	        });
	    }).change();
	});

	function Formula1Calc(){
	    //Here we get the total price by calling our function
	    //Each function returns a number so by calling them we add the values they return together
		var divobj = document.getElementById('Formula1Output');
	    divobj.style.display='none';

	    var Rate = 0;
	    var PresentValue = 0;
	    var Terms = 0;
	    var LoanInstallment = 0;
	    var Term_Mult = 0;
	    var AnnualRate = 0;
	    var MonthlyRate = 0;
	    var Term_Multiplier = 12;

	   
	    var Formula1Form = document.forms["Formula1Form"];
	    PresentValue = Formula1Form.elements['f1_pv'].value;
	    Rate = Formula1Form.elements['f1_r'].value;
	    Terms = Formula1Form.elements['f1_n'].value;
	    
	    $("select[id='Term_Multiplier1']").change(function(){
	        $(this).find("option:selected").each(function(){

	            if($(this).attr("value")=="months"){
	                Terms = Terms;
	                
	            }
	            else if($(this).attr("value")=="years"){
	                Terms = Terms * Term_Multiplier;0;
	            }
	        });
	    }).change();

	    AnnualRate = Rate;
		MonthlyRate = AnnualRate/12;
		DecimalMonthlyRate = MonthlyRate/100;

	    

	    // LoanInstallment = (DecimalMonthlyRate*PresentValue*Math.pow((1+DecimalMonthlyRate), Terms)) / (Math.pow((1+DecimalMonthlyRate), Terms)-1); 
	    LoanInstallment = (DecimalMonthlyRate*PresentValue) / (1 - Math.pow((1+DecimalMonthlyRate), -Math.abs(Terms)));
	    // LoanInstallment = DecimalMonthlyRate;
	    LoanInstallment = LoanInstallment.toFixed(2);

	    //display the result
	    var divobj = document.getElementById('Formula1Output');
	    divobj.style.display='block';
	    divobj.innerHTML = "Monthy Amortization: Php "+LoanInstallment;

		}

		function resetAll(){
			var divobj = document.getElementById('Formula1Output');
	    	divobj.style.display='none';
		}
	</script>
@stop