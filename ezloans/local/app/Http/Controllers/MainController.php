<?php

namespace App\Http\Controllers;
use View;
use Session;
use Illuminate\Http\Request;
use DB;
use App\User;

class MainController extends Controller
{
   	public function dashboard($domain, $user_id){
		$userinfo = DB::table('users')
				->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
	            ->where('cooperatives.coop_domain', $domain)
	            ->where('user_id', $user_id)
	            ->first();

	    $pendings = DB::table('loan_users')
            ->where('loan_user_request', '1')
            ->count();

        $userinfo = json_decode(json_encode($userinfo), True);
        $pendings = json_decode(json_encode($pendings), True);

        $userinfo['pendings'] = $pendings;

		return View::make('pages.members.Dashboard')->with('domain', $domain)->with('userinfo', $userinfo);
	}
}
