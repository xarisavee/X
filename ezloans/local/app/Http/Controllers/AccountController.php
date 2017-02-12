<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use View;
use Hash;
use DB;
use Carbon\Carbon;
use App\cooperative;
use App\User;
use App\Login;
use App\RoleUser;
use App\UserEmployment;
use App\UserSpouse;
use Auth;
use AuthenticatesAndRegistersUsers;
use App\Mail\WelcomeToEzloans;
use Mail;

class AccountController extends Controller
{
	public function register(){
		Session::put(Request::all());
		$data = Session::all();
		// print_r($data);
		return Redirect::route('companysetup');
	}

	public function completeaccount(){
		$clientinfo = [];
		$clientinfo['comp_name'] = Session::get('comp_name');
		$clientinfo['user_email'] = Session::get('user_email');

		return View::make('pages.setup.accountsetup')->with('clientinfo', $clientinfo);
	}

	public function completeaccountsave(){
		Session::put(Request::all());
    	$data = Session::all();

		$cooperative = new cooperative;
		$user = new User;
		$login = new login;
		$roleuser = new RoleUser;
		$spouse = new UserSpouse;
		$employment = new UserEmployment;
		// $cooprole = new CoopRoles;

		// $cooprolelist = $this->getRolesToCoop();

		$coop_domain = strtolower(Input::get('coop_domain'));
		$coop_name = ucwords(Input::get('coop_name'));
		$coop_address = ucwords(Input::get('coop_address'));
		$coop_contact = Input::get('coop_contact');
		$coop_email = Input::get('coop_email');
		$user_fname = ucwords(Input::get('user_fname'));
		$user_mname = ucwords(Input::get('user_mname'));
		$user_lname = ucwords(Input::get('user_lname'));
		$password = Hash::make(Input::get('user_password'));

		$coop_id = $this->getCoopId();

		$cooperative->coop_id = $coop_id;
		$cooperative->coop_domain = $coop_domain;
		$cooperative->coop_name = $coop_name;
		$cooperative->coop_address = $coop_address;
		$cooperative->coop_contact = $coop_contact;
		$cooperative->coop_email = $coop_email;
		$cooperative->save();

		$user_id = $this->getUserId($coop_id);

		$user->coop_id = $coop_id;
		$user->user_id = $user_id;
		$user->user_fname = $user_fname;
		$user->user_mname = $user_mname;
		$user->user_lname = $user_lname;
		$user->user_email = $coop_email;
		$user->user_status = 1;
		$user->user_created = Carbon::now();
		$user->save();

		$login->coop_id = $coop_id;
		$login->user_id = $user_id;
		$login->user_email = $coop_email;
		$login->password = $password;
		$login->remember_token = $data['_token'];
		$login->save();

		$roleuser->coop_id = $coop_id;
		$roleuser->user_id = $user_id;
		$roleuser->roleuser_id = $this->getRoleUser_id($coop_id);
		$roleuser->role_id = $this->giveRoles($coop_id, $user_id);
		$roleuser->role_status = 1;
		$roleuser->save();

		$spouse->coop_id = $coop_id;
        $spouse->user_id = $user_id;
        $spouse->user_spouse_name = "";
        $spouse->user_spouse_occupation = "";
        $spouse->user_spouse_contact = "";

        $employment->coop_id = $coop_id;
        $employment->user_id = $user_id;
        $user_emp_sector = "";

        if ($user_emp_sector == "Others"){
            $employment->user_emp_sector = "";
        }else{
            $employment->user_emp_sector = $user_emp_sector;
        }

        $employment->user_emp_occupation = "";
        $employment->user_emp_name = "";
        $employment->user_emp_address = "";
        $employment->user_emp_contact = "";

        $spouse->save();
        $employment->save();

		$password = Input::get('user_password');

		if($this->welcomeEmail($coop_email, $user_fname, $coop_domain)){
			return $this->cauthenticate($coop_id, $coop_email, $password, $coop_domain, $user_id);
		}else{
			echo "POPO";
		}

		
		
	}

	public function cauthenticate($coop_id, $coop_email, $password, $coop_domain, $user_id){
		$user=[
	    	'coop_id' => $coop_id,
	        'user_email' =>  $coop_email,
	        'password'  => $password
	    ];

        if (Auth::attempt($user)) {

        	$userinfo = DB::table('users')
                ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
                ->where('cooperatives.coop_domain', $coop_domain)
                ->where('user_email', $coop_email)
                ->first();

        	$userinfo = json_decode(json_encode($userinfo), True);

            return Redirect::route('getmemberprofile', array('domain' => $coop_domain, 'user_id' => $user_id, 'member_id' => $user_id));
            // return true;
        }else{
        	// echo $coop_id."    ".$coop_email."     ".$password;
        	return Redirect::route('home', array('domain' => $coop_domain));
        }
        
    }

    public function welcomeemail($coop_email, $user_fname, $coop_domain){
    	$domain = "localhost/ezloans/".$coop_domain;

    	$welcomeuser = ['email' => $coop_email, 'name' => $user_fname, 'domain' => $domain];
		Mail::to($coop_email)->send(new WelcomeToEzloans($welcomeuser));
		return true;
    }

	private function getRoleUser_id($coop_id){
		$roleuser_id = DB::table('role_users')->where('coop_id', $coop_id)->where('user_id')->count();
		$roleuser_id++;
		return $roleuser_id;
	}

	private function getRolesToCoop(){
		$roles = DB::table('roles')->get()->toArray();
		$roles = json_decode(json_encode($roles), true);
		$rolelist = [];

		foreach($roles as $role){
			foreach($role as $key => $data){
				$rolelist[$key] = $data;
			}
		}


		return $rolelist;
	}

	private function getCoopId(){
		$coop_id = DB::table('cooperatives')->count();
		$coop_id++;
		return $coop_id;
	}

	private function getUserId($coop_id){
		$countuser = DB::table('users')->where('coop_id', $coop_id)->count();
		$countuser++;

		$year = Carbon::now()->year;
		$month = Carbon::now()->month;

		if ($month < 10) {
            $month = "0".$month;
        }

        if ($countuser<100 && $countuser>10){
            $countuser="0".$countuser;
            $user_id = $year.$month.$countuser;
        }
        else if ($countuser<10){
            $countuser="00".$countuser;
            $user_id = $year.$month.$countuser;
        }
        else{
            $user_id = $year.$month.$countuser;
        }

		return $user_id;
	}

	private function giveRoles($coop_id, $user_id){
		$roles = DB::table('roles')->select('role_id')->where('role_desc', 'Superadmin')->get()->toArray();
		$roles = json_decode(json_encode($roles), true);

		foreach($roles as $role){
			$role_of_user = $role['role_id'];
		}

		return $role_of_user;
	}
}
