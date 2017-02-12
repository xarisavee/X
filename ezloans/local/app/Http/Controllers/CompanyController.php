<?php

namespace App\Http\Controllers;

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
use App\Cooperative;
use Hash;
use Redirect;
use Flash;
use Illuminate\Support\MessageBag;

class CompanyController extends Controller
{
    public function companySettings($domain, $user_id){
    	$domain = $domain;
    	$userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $coop_id = $this->getCoopId($domain);

        $companydetails = DB::table('cooperatives')
            ->where('coop_id', $coop_id)
            ->get()->toArray();

        $companydetails = json_decode(json_encode($companydetails), True);

    	return view::make('pages.setup.coopsetup')
    		->with('domain', $domain)
    		->with('user_id', $user_id)
            ->with('companydetails', $companydetails)
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

    public function getCoopId($domain){
        $coop = DB::table('cooperatives')->select('coop_id')->where('coop_domain', $domain)->first();
        $coop = json_decode(json_encode($coop), True);
        $coop_id = $coop['coop_id'];

        return $coop_id;
    }

    public function updateCompanySettings($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);

        $coop = new Cooperative;
        $coop = DB::table('cooperatives')
            ->where('coop_id', $coop_id)
            ->update([
                    'coop_foundation_date' => Input::get('coop_foundationdate'),
                    'coop_authsharecapital' => Input::get('coop_authsharecapital'),
                    'coop_sharecapital' => Input::get('coop_sharecapital')
                    ]
            );

        return back();
    }
}
