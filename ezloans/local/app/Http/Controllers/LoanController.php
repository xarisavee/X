<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EqualPrincipalCalculator;
use View;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Login;
use App\CoopDetails;
use App\SetFeatures;
use App\Role;
use App\Loan;
use App\LoanRate;
use App\LoanSeason;
use App\LoanUser;
use App\LoanRequest;
use App\LoanCoMaker;
use Hash;
use Redirect;
use Flash;
use Illuminate\Support\MessageBag;

class LoanController extends Controller
{
	public function createloan($domain, $user_id){
		$domain = $domain;
    	$userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

    	return view::make('pages.loans.addloan')
    		->with('domain', $domain)
    		->with('user_id', $user_id)
            ->with('userinfo', $userinfo);
    }

    public function getCurrentUser($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);

        $userinfo = DB::table('users')
                ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
                ->where('cooperatives.coop_domain', $domain)
                ->where('user_id', $user_id)
                ->first();
                
        $pendings = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('loan_user_request', '1')
            ->count();


        $userinfo = json_decode(json_encode($userinfo), True);
        $pendings = json_decode(json_encode($pendings), True);

        $userinfo['pendings'] = $pendings;

        return $userinfo;
    }

    public function saveloan($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $loan_id = $this->getLoanId($coop_id);

        $loan = new Loan;
        // $loanrate = new LoanRate;
        $loanseason = new LoanSeason;

        $loan->coop_id = $coop_id;
        $loan->loan_id = $loan_id;
        $loan->loan_name = Input::get('loan_name');
        $loan->loan_desc = Input::get('loan_desc');
        $loan->loan_maxamount = Input::get('loan_maxamount');
        $loan->loan_status = 1;
        
        // $loanrate->coop_id = $coop_id;
        // $loanrate->loan_id = $loan_id;
        // $loanrate->loan_rate_value = Input::get('loan_rate');
        // $loanrate->loan_rate_status = 1;
        
        $loan_availability = Input::get('loan_availability');

        if($loan_availability == "Seasonal"){
            $loanseason->coop_id = $coop_id;
            $loanseason->loan_id = $loan_id;
            $loanseason->loan_season_start = Input::get('season_start');
            $loanseason->loan_season_end = Input::get('season_end');
            $loanseason->loan_season_status = 1;

            if($this->saveLoanData1($loan, $loanseason)){
                Session::put('flash_message', 'Successfully added new loan.');
                return Redirect::route('addnewloan', array('domain' => $domain, 'user_id' => $user_id));
            }else{
                $errors = new MessageBag(['loan' => ['There was an error in adding the loan.']]);
                return Redirect::route('addnewloan', array('domain' => $domain, 'user_id' => $user_id))->withErrors($errors);
            }
        }else{
            if($this->saveLoanData2($loan)){
                Session::put('flash_message', 'Successfully added new loan.');
                return Redirect::route('addnewloan', array('domain' => $domain, 'user_id' => $user_id));
            }else{
                $errors = new MessageBag(['loan' => ['There was an error in adding the loan.']]);
                return Redirect::route('addnewloan', array('domain' => $domain, 'user_id' => $user_id))->withErrors($errors);
            }
        }
        
    }

    public function getCoopId($domain){
        $coop = DB::table('cooperatives')->select('coop_id')->where('coop_domain', $domain)->first();
        $coop = json_decode(json_encode($coop), True);
        $coop_id = $coop['coop_id'];

        return $coop_id;
    }

    private function getLoanId($coop_id){
        $loan_id = DB::table('loans')->where('coop_id', $coop_id)->count();
        $loan_id++;
        return $loan_id;
    }

    public function saveLoanData1($loan, $loanseason){
        $loan->save();
        $loanrate->save();
        $loanseason->save();

        return true;
    }

    public function saveLoanData2($loan){
        $loan->save();
        // $loanrate->save();

        return true;
    }

    public function getallloans($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

        // $loanlist = DB::table('loans')
        //     ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
        //     ->where('loans.coop_id', $coop_id)
        //     ->where('loans.loan_status', "1")
        //     ->get()->toArray();

        $loanlist = DB::table('loans')
            // ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
            ->leftJoin('loan_seasons', 'loan_seasons.loan_id', 'loans.loan_id')
            ->where('loans.coop_id', $coop_id)
            // ->where('loan_rates.loan_rate_status', "1")
            ->where('loans.loan_status', "1")
            ->get()->toArray();

        $loanlist = json_decode(json_encode($loanlist), True);
        // $loanlist2 = json_decode(json_encode($loanlist2), True);


        // echo "<pre>"; print_r($loanlist);echo "</pre>";
        // echo "<pre>"; print_r($loanlist2);echo "</pre>"; 
        return view::make('pages.loans.viewloans')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('loanlist', $loanlist);
    }

    public function applyloan($domain, $user_id, $member_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $member_id = $member_id;
        $totalshare = 0; 

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        $loanlist = DB::table('loans')
            // ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
            // ->leftJoin('loan_seasons', 'loan_seasons.loan_id', 'loans.loan_id')
            ->where('loans.coop_id', $coop_id)
            ->where('loans.loan_status', "1")
            ->get()->toArray();

        $seasons = DB::table('loans')
            ->select('loans.loan_id', 'loans.loan_name', 'loans.loan_desc', 'loans.loan_maxamount', 'loan_seasons.loan_season_start', 'loan_seasons.loan_season_end' )
            // ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
            ->leftJoin('loan_seasons', 'loan_seasons.loan_id', 'loans.loan_id')
            ->where('loans.coop_id', $coop_id)
            ->where('loans.loan_status', "1")
            ->get()->toArray();

        $membershare = DB::table('share_capitals')
            ->select('share_amount')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();

        $interestmethod = DB::table('interest_methods')
            ->get()->toArray();

        $loanlist = json_decode(json_encode($loanlist), True);
        $seasons = json_decode(json_encode($seasons), True);
        $memberprofile = json_decode(json_encode($memberprofile), True);
        $interestmethod = json_decode(json_encode($interestmethod), True);
        $membershare = json_decode(json_encode($membershare), True);

        foreach($membershare as $share => $key){
            $totalshare += (int)$key['share_amount'];
        }


        return view::make('pages.loans.applyloan')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('member_id', $member_id)
            ->with('seasons', $seasons)
            ->with('interestmethod', $interestmethod)
            ->with('totalshare', $totalshare)
            ->with('memberprofile', $memberprofile);
        // echo "<pre>"; print_r($seasons); echo "</pre>";
        
    }

    public function getLoanDetailsAjax($domain, $user_id, $member_id, $id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $user_id = $userinfo['user_id'];

        $loanDetails = DB::table('loans')
            ->select('loans.loan_id', 'loans.loan_name', 'loans.loan_desc', 'loans.loan_maxamount', 'loan_seasons.loan_season_start', 'loan_seasons.loan_season_end' )
            ->join('cooperatives', 'cooperatives.coop_id', 'loans.coop_id')
            // ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
            ->leftJoin('loan_seasons', 'loan_seasons.loan_id', 'loans.loan_id')
            ->where('loans.coop_id', $coop_id)
            ->where('loans.loan_id', $id)
            ->get()->toArray();

        // $loanDetails = json_decode(json_encode($loanDetails), True);
        // echo "<pre>"; print_r($seasons); echo "</pre>";
        return $loanDetails;
    }

    public function applynew_comakers($domain, $user_id, $member_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

        $member_id = $member_id;

        session()->put('member_id', $member_id);
        session()->put('loan_id', Input::get('loanid'));
        session()->put('disbursement', Input::get('disbursement'));
        session()->put('releasedate', Input::get('releasedate'));
        session()->put('method', Input::get('interest_method'));
        session()->put('retention', Input::get('retention'));
        session()->put('processing', Input::get('processing'));
        session()->put('rate', Input::get('rate'));
        session()->put('accumulation', Input::get('interest_accumulation'));
        session()->put('terms', Input::get('terms'));
        session()->put('duration', Input::get('duration'));
        session()->put('repayment', Input::get('repayment_type'));
        session()->put('amount', Input::get('amount'));

        // echo "<pre>"; print_r(session()->all()) ; echo "</pre>";
        // return Redirect::route('applynew_comakersview', array('domain' => $domain, 'user_id' => $userinfo['user_id'], 'member_id' => $member_id));
        return view::make('pages.loans.listcomakers')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('member_id', $member_id)
            ->with('userinfo', $userinfo);
    }

    public function applynewloan($domain, $user_id, $member_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

        $member_id = $member_id;
        $terms = session::get('terms');
        $releasedate = session::get('releasedate');
        $duration = session::get('duration');
        $enddate = $this->convertTerm($releasedate, $terms, $duration);
        $loan_user = new loanUser;
        $comakers = new LoanCoMaker;

        $loan_user_id = $this->getLoanUserId($coop_id, $member_id);

        $loan_user->coop_id = $coop_id;
        $loan_user->user_id = $member_id;
        $loan_user->loan_user_id = $loan_user_id;
        $loan_user->loan_id = session::get('loan_id');
        $loan_user->loan_user_interest_method = session::get('method');
        $loan_user->loan_user_disbursement = session::get('disbursement');
        $loan_user->loan_user_amount = session::get('amount');
        $loan_user->loan_user_amortization = session::get('amortization');
        $loan_user->loan_user_rate = session::get('rate');
        $loan_user->loan_user_terms = session::get('terms');
        $loan_user->loan_user_duration = $duration;
        $loan_user->loan_user_accumulation = session::get('accumulation');
        $loan_user->loan_user_repayment = session::get('repayment');
        $loan_user->loan_user_retention = session::get('retention');
        $loan_user->loan_user_processing = session::get('processing');
        $loan_user->loan_user_termstart = session::get('releasedate');
        $loan_user->loan_user_termend = $enddate;
        $loan_user->user_addedby = $user_id;
        $loan_user->loan_user_request = "1";
        $loan_user->loan_user_status = 1;
        
        $CoMakers = [];
        $CoMakers['coop_id'] = $coop_id;
        $CoMakers['user_id'] = $member_id;
        $CoMakers['name'] = Input::get('comaker_name');
        $CoMakers['address'] = Input::get('comaker_address');
        $CoMakers['sex'] = Input::get('comaker_sex');
        $CoMakers['contact'] = Input::get('comaker_contact');
        $CoMakers['relation'] = Input::get('comaker_relation');

        return $this->saveLoanDetails($loan_user, $CoMakers, $member_id, $coop_id, $loan_user_id, $domain, $user_id);

        // echo "<pre>"; print_r(session()->all()) ; echo "</pre>";

    }

    private function saveLoanDetails($loan_user, $CoMakers, $member_id, $coop_id, $loan_user_id, $domain, $user_id){
        $loan_user->save();
        $num_elements = 0;

        while($num_elements < count($CoMakers['name']))
        {
            $comaker_array = array(
                'coop_id'           => $coop_id,
                'user_id'           => $member_id,
                'loan_user_id'      => $loan_user_id,
                'comaker_id'        => $num_elements+1,
                'comaker_name'      => $CoMakers['name'][$num_elements],
                'comaker_address'   => $CoMakers['address'][$num_elements],
                'comaker_sex'       => $CoMakers['sex'][$num_elements],
                'comaker_contact'   => $CoMakers['contact'][$num_elements],
                'comaker_relationship'  => $CoMakers['relation'][$num_elements]
            );
            DB::table('loan_co_makers')->insert($comaker_array);
            $num_elements++;  
        } 

        // return $this->saveSchedule($domain, $user_id, $member_id, $loan_user_id);
        return $this->returnToLoanBook($domain, $user_id, $member_id);
    }
    public function saveSchedule($domain, $user_id, $member_id, $loan_user_id){
        $intmethod = session::get('method');

        if($intmethod == '1'){
            return Redirect::route('saveflatrateschedule', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
        else if($intmethod == '2'){
            return Redirect::route('saveequalamortizationsched', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
        else if($intmethod == '3'){
            return Redirect::route('saveequalprincipalsched', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
    }

    public function returnToLoanBook($domain, $user_id, $member_id){
        return Redirect::route('viewmemberloanbook', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id));
    }

    public function getLoanUserId($coop_id, $member_id){
        $loan_user_id = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->count();
        $loan_user_id++;

        return $loan_user_id;
    }

    public function convertTerm($releasedate, $terms, $duration){
        $startdate = $releasedate;
        $enddate = date('Y-m-d', strtotime($releasedate ."+".$terms." ".strtolower($duration)));
        return $enddate;
        // echo $enddate;
    }

    public function loanrequests($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

        // $loanlist = DB::table('loans')
        //     ->join('loan_rates', 'loans.loan_id', 'loan_rates.loan_id')
        //     ->where('loans.coop_id', $coop_id)
        //     ->where('loans.loan_status', "1")
        //     ->get()->toArray();

        $loanrequestlist = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->join('loan_users', 'loan_users.user_id', 'users.user_id')
            ->join('loans', 'loans.loan_id', 'loan_users.loan_id')
            ->join('loan_requests', 'loan_request_id', 'loan_users.loan_user_request')
            ->where('loans.coop_id', $coop_id)
            ->where('loan_users.loan_user_request', '1')    
            ->get()->toArray();

        $loanrequestlist = json_decode(json_encode($loanrequestlist), True);
        // echo "<pre>"; print_r($loanrequestlist);echo "</pre>"; 
        return view::make('pages.loans.loanrequests')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('loanrequestlist', $loanrequestlist);
    }

    public function loanrequestaction(Request $request, $domain, $user_id, $member_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $member_id = $request->member_id;
        $loan_user_id = $request->loan_user_id;
        $action = $request->action;
    
        if($action == "2"){
        
            $loan_user = DB::table('loan_users')
                ->where('coop_id', $coop_id)
                ->where('user_id', $member_id)
                ->where('loan_user_id', $loan_user_id)
                ->update(['loan_user_request' => $action]);
                
               if($loan_user){
                return 2;
                }else{
                    return 4;
                }
        }else{
            $remarks = $request->remarks;

             $loan_user = DB::table('loan_users')
                ->where('coop_id', $coop_id)
                ->where('user_id', $user_id)
                ->update(['loan_user_request' => $action,
                        'loan_user_comment' => $remarks
                    ]);

            if($loan_user){
                return 3;
            }else{
                return 4;
            }
        }
       
    }

    public function getmemberoverview($domain, $user_id, $member_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $back= 1;

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();


        $memberloans = DB::table('loan_users')
            ->select('loan_users.loan_user_id', 'loans.loan_name', 'loan_users.loan_user_amount', 'loan_users.loan_user_rate', 'loan_users.loan_user_amortization', 'loan_users.loan_user_terms', 'loan_users.loan_user_duration', 'loan_users.loan_user_termstart', 'loan_users.loan_user_termend', 'loan_users.loan_user_request', 'loan_request_desc')
            ->join('cooperatives', 'cooperatives.coop_id', 'loan_users.coop_id')
            ->join('loans', 'loan_users.loan_id', 'loans.loan_id')
            ->join('users', 'loan_users.user_id', 'users.user_id')
            ->join('loan_requests', 'loan_requests.loan_request_id', 'loan_users.loan_user_request')
            // ->join('loan_rates', 'loan_rates.loan_id', 'loans.loan_id')
            ->where('loan_users.coop_id', $coop_id)
            ->where('loan_users.user_id', $member_id)
            ->get()->toArray();

        $memberprofile = json_decode(json_encode($memberprofile), True);
        $memberloans = json_decode(json_encode($memberloans), True);

        foreach ($memberloans as $loans => $key) {
            $memberloans[0]['loan_user_termstart'] = date('M d, Y', strtotime($key['loan_user_termstart']));
            $memberloans[0]['loan_user_termend'] = date('M d, Y', strtotime($key['loan_user_termend']));
        }

        return view::make('pages.loans.loanrequestoverview')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('member_id', $member_id)
            ->with('back', $back)
            ->with('memberloans', $memberloans)
            ->with('memberprofile', $memberprofile);
    }

 /*   public function getUserLoanDetails(Request $request, $domain, $user_id, $member_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $loan_user_id = $request->loan_user_id;

        $userdetails = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->get()->toArray();

        $userdetails = json_decode(json_encode($userdetails), True);

        return $userdetails;
    }

    public function getUserLoanSched(Request $request, $domain, $user_id, $member_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $loan_user_id = $request->loan_user_id;

        return $request;
    }*/

    public function getUserLoanDetails($domain, $user_id, $member_id, $loan_user_id){
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

        $userdetails = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->where('loan_user_status', 1)
            ->first();

        $userdetails = json_decode(json_encode($userdetails), True);

        if($userdetails['loan_user_interest_method'] == "1"){
           return Redirect::route('flatratenoajax', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
        else if($userdetails['loan_user_interest_method'] == "2"){
            return Redirect::route('equalamortizationnoajax', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
        else if($userdetails['loan_user_interest_method'] == "3"){
            return Redirect::route('equalprincipalnoajax', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        }
    }
}


