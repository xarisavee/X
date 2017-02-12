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
use App\RoleUser;
use Hash;
use Redirect;
use Flash;
use App\Mail\PromoteUser;
use Mail;

class RoleController extends Controller
{
  	public function getRoles($domain, $user_id){
    	$domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];

        $regularmembers = $this->getRegularMembers($coop_id);
        $authorized = $this->getMembersWithRoles($coop_id);
        $unauthorized = $this->array_diff_assoc_recursive($regularmembers, $authorized);
        $roles = $this->getRolesOnly();

        // echo "<pre>"; print_r($hasroles); echo "</pre>";
    	return view::make('pages.users.pageroles2')
    		->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('authorized', $authorized)
            ->with('unauthorized', $unauthorized)
            ->with('roles', $roles);
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

    public function getRegularMembers($coop_id){
    	/*$regmemberlist = DB::table('role_users')
    		->join('roles', 'roles.role_id', 'role_users.role_id')
    		->join('users', 'role_users.user_id', 'users.user_id')
    		->where('role_users.coop_id', $coop_id)
    		->where('role_users.role_status', 1)
    		->get()->toArray();*/

		$regmemberlist = DB::table('users')
    		->where('coop_id', $coop_id)
    		->get()->toArray();

    	$regmemberlist = json_decode(json_encode($regmemberlist), True);

    	return $regmemberlist;
    }

    public function getMembersWithRoles($coop_id){
    	$withroles =  DB::table('role_users')
    		->join('roles', 'roles.role_id', 'role_users.role_id')
    		->join('users', 'role_users.user_id', 'users.user_id')
    		->where('role_users.coop_id', $coop_id)
    		->where('role_users.role_status', 1)
    		->orderBy('role_users.role_id')
    		->get()->toArray();

    	$withroles = json_decode(json_encode($withroles), True);

    	return $withroles;
    }

        public function array_diff_assoc_recursive($array1, $array2){
		foreach($array1 as $key => $value)
		{
			if(is_array($value))
			{
				if(!isset($array2[$key]))
				{
					$difference[$key] = $value;
				}
				elseif(!is_array($array2[$key]))
				{
					$difference[$key] = $value;
				}
				// else
				// {
				// 	$new_diff = $this->array_diff_assoc_recursive($value, $array2[$key]);
				// 	if($new_diff != FALSE)
				// 	{
				// 		$difference[$key] = $new_diff;
				// 	}
				// }
			}
			elseif(!isset($array2[$key]) || $array2[$key] != $value)
			{
				$difference[$key] = $value;
			}
		}
		return !isset($difference) ? 0 : $difference;
	}

	public function getRolesOnly(){
		$rolesonly = [];

		$rolesonly = DB::table('roles')
			->where('role_id', '!=', '6')
			->where('role_id', '!=', '1')
			->get()->toArray();
		$rolesonly = json_decode(json_encode($rolesonly), True);

		return $rolesonly;
	}

	public function saveNewRoles($domain, $user_id){
    	$domain = $domain;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $roleuser = new RoleUser;
        $login = new Login;

    	$roleselect = Input::get('roleselect');
    	$id = Input::get('idFlag');
    	$email = Input::get('emailFlag');

		for($i=0; $i<count($roleselect); $i++){
			$roleuser->coop_id = $coop_id;
			$roleuser->roleuser_id = $this->countUser($coop_id);
			$roleuser->user_id = $id[$i];
			$roleuser->role_id = $roleselect[$i];
			$roleuser->role_status = 1;

			$login->coop_id = $coop_id;
			$login->user_id = $id[$i];
			$login->user_email = $email[$i];
			$user_email = $email[$i];
			$password = $this->makePassword();
			$userinfo = $this->getCurrentUser($domain, $id[$i]);
			$cooperative = $this->getCoopName($domain);
			$position = $this->getPosition($roleselect[$i]);

			if ($this->promoteUserEmail($domain, $user_email, $userinfo['user_fname'], $password, $cooperative[0]['coop_name'], $position[0]['role_desc'])){
				$login->password = Hash::make($password);
				$login->save();
				$roleuser->save();
			}
			
		}

		return Redirect::route('roleoverview', array('domain' => $domain, 'user_id'=> $user_id));
    }

    public function getCoopName($domain){
    	$coopname = DB::table('cooperatives')
    		->select('coop_name')
    		->where('coop_domain', $domain)
    		->get()->toArray();

    	$coopname = json_decode(json_encode($coopname), True);

    	return $coopname;
    }

    public function getPosition($role_id){
    	$position = DB::table('roles')
    		->select('role_desc')
    		->where('role_id', $role_id)
    		->get()->toArray();

    	$position = json_decode(json_encode($position), True);

    	return $position;
    }

    public function makePassword(){
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    $password = implode($pass); //turn the array into a string

	    return $password;
    }

    public function promoteUserEmail($domain, $user_email, $user_fname, $password, $cooperative, $position){
    	$domain = "localhost/ezloans/".$domain;

    	$promoteEmail = ['email' => $user_email, 'name' => $user_fname, 'password' => $password, 'domain' => $domain, 'cooperative' => $cooperative, 'position' => $position];
		Mail::to($user_email)->send(new PromoteUser($promoteEmail));
		return true;
    }

    public function countUser($coop_id){
    	$count = DB::table('role_users')
    		->where('coop_id', $coop_id)
    		->count();

    	$count++;
    	
    	return $count;
    }
}
