<?php

namespace App\Http\Controllers;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use App\Login;
use App\User;
use App\cooperative;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Hash;
use Redirect;
use AuthenticatesAndRegistersUsers;

class HomepageController extends Controller
{

	public function homepage(){
		return view('homepage');
	}

	public function signin($domain){
		$domain = $domain;
		$coop_name = $this->checkDomain($domain);

		if (isset($coop_name)){
			return view('loginpage')->with('domain', $domain)->with('coop_name', $coop_name);
		}else{
			$errors = new MessageBag(['domain' => ['The domain you entered is invalid.']]);
			return view('pages.error.register')->withErrors($errors);
		}
		
	}

	private function checkDomain($domain){
		$coop = DB::table('cooperatives')->select('coop_name')->where('coop_domain', $domain)->first();
		$coop = json_decode(json_encode($coop), True);
		$coop_name = $coop['coop_name'];
		// echo $coop_name;

		if($coop){
			return $coop_name;
		}else{
			return;
		}

	}

	public function signinRequest(Request $request, $domain){
		$domain = $domain;

		$login = new Login;
	    $user = new User;

	    $coopid = DB::table('cooperatives')->select('coop_id')->where('coop_domain', $domain)->get()->toArray();
	    $coopid = json_decode(json_encode($coopid), True);
	    
	    foreach($coopid as $coopId){
	    	foreach($coopId as $key => $data){
	    		$coop_id = $data;
	    	}
	    }

	    $user=[
	    	'coop_id' => $coop_id,
	        'user_email' =>  Input::get('logemail'),
	        'password'  => Input::get('logpassword'),
	    ];


	    if (Auth::attempt($user)){

            $userinfo = DB::table('users')
	            ->select('users.coop_id','cooperatives.coop_domain', 'role_users.role_id', 'users.user_id', 'users.user_fname', 'users.user_lname')
	            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
	            // ->join('roles', 'roles.role_id', 'role_users.role_id')
	            ->join('role_users', 'role_users.coop_id', 'cooperatives.coop_id')
	            ->where('cooperatives.coop_domain', $domain)
	            ->where('users.user_email' , $user['user_email'])
	            ->first();

	        $userinfo = json_decode(json_encode($userinfo), True);

            $userinfo['fullname'] = ucwords($userinfo['user_fname']." ".$userinfo['user_lname']);

            print_r($userinfo);
	        return Redirect::route('dashboard', array('domain' => $domain, 'user_id' => $userinfo['user_id']));
	    }
	    else{
            $errors = new MessageBag(['password' => ['Incorrect email/password. Please retry.']]);
	    	return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
	    }
    }

    public function signout(){
    	Auth::logout();
        // Session::flush(all);
        return Redirect::route('home');
    }
}
