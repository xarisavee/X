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
                            <div class="col-lg-6">
                                <form method="post" action="">  
                                 
                                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">        
                                    <input class="form-control btn btn-danger" type="submit" value="Setup Complete">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection