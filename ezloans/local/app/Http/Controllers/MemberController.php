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
use App\UserEmployment;
use App\UserSpouse;
use Hash;
use Redirect;
use Flash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function addmember($domain, $user_id){
    	$domain = $domain;
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $user_id = $userinfo['user_id'];
        $member_id = $this->getMemberId($domain);
    	// $user_id = $id;
    	// $userinfo = Session::get('userinfo');

     //    $count = DB::table('users')
     //                ->where('created_at', '>=', 'CURRENT_DATE')
     //                ->count(); //Count entries for that day.


     //    $year = Carbon::now()->year;
     //    $month = Carbon::now()->month;

     //    if ($month < 10) {
     //        $month = "0".$month;
     //    }

     //    $count++;
     //    if ($count<100 && $count>10){
     //        $count="0".$count;
     //        $newmember_id = $year.$month.$count;
     //    }
     //    else if ($count<10){
     //        $count="00".$count;
     //        $newmember_id = $year.$month.$count;
     //    }
     //    else{
     //        $newmember_id = $year.$month.$count;
     //    }

    	return view::make('pages.members.addmember')
            ->with('domain', $domain)
    		->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('member_id', $member_id);
    }

    public function getMemberId($domain){
        $countuser = DB::table('users')
            ->join('cooperatives', 'users.coop_id', 'cooperatives.coop_id')
            ->where('cooperatives.coop_domain', $domain)
            ->count();
        $countuser++;

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        if ($month < 10) {
            $month = "0".$month;
        }

        if ($countuser<100 && $countuser>10){
            $countuser="0".$countuser;
            $member_id = $year.$month.$countuser;
        }
        else if ($countuser<10){
            $countuser="00".$countuser;
            $member_id = $year.$month.$countuser;
        }
        else{
            $member_id = $year.$month.$countuser;
        }

        return $member_id;
    }

    public function getCurrentUser($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);

        $userinfo = DB::table('users')
                ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
                // ->join('loan_users', 'loan_users.coop_id', 'cooperatives.coop_id')
                // ->join('loan_requests', 'loan_users.loan_user_request', 'loan_requests.loan_request_id')
                ->where('cooperatives.coop_domain', $domain)
                // ->where('loan_users.loan_user_request', '1')
                ->where('users.user_id', $user_id)
                ->first();

        $pendings = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('loan_user_request', '1')
            ->count();


        $userinfo = json_decode(json_encode($userinfo), True);
        $pendings = json_decode(json_encode($pendings), True);

        $userinfo['pendings'] = $pendings;

        // echo "<pre>"; print_r($userinfo); echo "</pre>";

        return $userinfo;
    }

    public function addmembersave($domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $user_id = Input::get('member_id');
        $user = new User;
        $spouse = new UserSpouse;
        $employment = new UserEmployment;

        $avatar = Input::file('user_pic');
        $ext = $avatar->guessClientExtension();
        $filename = "avatar.".$ext;
        $destination = 'local/storage/app/members/'.$user_id;
        $storage = 'members/'.$user_id;
        $avatar->storeAs($storage, $filename);

        // echo $destination."/".$filename;

        $user->coop_id = $coop_id;
        $user->user_id = $user_id;
        $user->user_fname = Input::get('member_fname');
        $user->user_mname = Input::get('member_mname');
        $user->user_lname = Input::get('member_lname');
        $user->user_sex = Input::get('member_sex');
        $user->user_civilstatus = Input::get('member_civilstatus');
        $user->user_bday = Input::get('member_bday');
        $user->user_bplace = Input::get('member_bplace');
        $user->user_address = Input::get('member_address');
        $user->user_mobile = Input::get('member_mobile');
        $user->user_landline = Input::get('member_landline');
        $user->user_email = Input::get('member_email');
        $user->user_zip = Input::get('member_zip');
        $user->user_nationality = Input::get('member_nationality');
        $user->user_religion = Input::get('member_religion');
        $user->user_photo = $destination."/".$filename;
        $user->user_educAttain = Input::get('member_educAttain');
        $user->user_school = Input::get('member_school');
        $user->user_schooladdress = Input::get('member_schooladdress');
        $user->user_addedby = $currentuser;
        $user->user_created = Carbon::now();
        $user->user_status = 1;

        $spouse->coop_id = $coop_id;
        $spouse->user_id = $user_id;
        $spouse->user_spouse_name = Input::get('member_spouse_name');
        $spouse->user_spouse_occupation = Input::get('member_spouse_occupation');
        $spouse->user_spouse_contact = Input::get('member_spouse_contact');

        $employment->coop_id = $coop_id;
        $employment->user_id = $user_id;
        $user_emp_sector = Input::get('member_emp_sector');

        if ($user_emp_sector == "Others"){
            $employment->user_emp_sector = Input::get('member_empsector_other');
        }else{
            $employment->user_emp_sector = $user_emp_sector;
        }

        $employment->user_emp_occupation = Input::get('member_emp_occupation');
        $employment->user_emp_name = Input::get('member_emp_name');
        $employment->user_emp_address = Input::get('member_emp_address');
        $employment->user_emp_contact = Input::get('member_emp_contact');

        if ($this->saveData($user, $spouse, $employment)){
            Session::put('flash_message', 'Successfully added new member.');
            return Redirect::route('addmember', array('domain' => $domain, 'user_id' => $currentuser));
        }else{
            $errors = new MessageBag(['member' => ['There was an error in adding the member.']]);
            return Redirect::route('addmember', array('domain' => $domain, 'user_id' => $currentuser))->withErrors($errors);
        }
    }

    public function saveData($user, $spouse, $employment){
        $user->save();
        $spouse->save();
        $employment->save();

        return true;
    }

    public function saveComakers($user, $comakers, $coop_id, $user_id){
        $user->save();

        $num_elements = 0;
        $comaker_array = [];

        while($num_elements < count($comakers['name']))
        {
            $comaker_array = array(
                'coop_id'           => $coop_id,
                'user_id'           => $user_id,
                'comaker_id'        => $num_elements+1,
                'comaker_name'      => $comakers['name'][$num_elements],
                'comaker_address'   => $comakers['address'][$num_elements],
                'comaker_contact'   => $comakers['contact'][$num_elements],
                'comaker_relationship'  => $comakers['relation'][$num_elements]
            );
            DB::table('co_makers')->insert($comaker_array);
            $num_elements++;  
        }
        return true;
    }

    public function getCoopId($domain){
        $coop = DB::table('cooperatives')->select('coop_id')->where('coop_domain', $domain)->first();
        $coop = json_decode(json_encode($coop), True);
        $coop_id = $coop['coop_id'];

        return $coop_id;
    }

    public function getallmembers($domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

        $memberlist = DB::table('users')
            ->select('user_id', 'user_fname', 'user_lname')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('user_status', '=', "1")
            ->get()->toArray();

        $checkLoans = DB::table('loans')->where('coop_id', $coop_id)->count();

        $memberlist = json_decode(json_encode($memberlist), True);
        // echo "<pre>";
        // print_r($memberlist);
        // echo "</pre>";
        return view::make('pages.members.viewallmembers')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('checkLoans', $checkLoans)
            ->with('memberlist', $memberlist);
    }

    public function getmemberprofile($domain, $user_id, $member_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            // ->join('user_employments', 'user_employments.user_id', 'users.user_id')
            // ->join('user_spouses', 'user_spouses.user_id', 'users.user_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        /*$member_comakers = DB::table('co_makers')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();*/

        $memberemployment = DB::table('user_employments')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();

        $memberspouse = DB::table('user_spouses')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();

        // $member_comakers = json_decode(json_encode($member_comakers), True);
        $memberprofile = json_decode(json_encode($memberprofile), True);
        $memberspouse = json_decode(json_encode($memberspouse), True);
        $memberemployment = json_decode(json_encode($memberemployment), True);

        // echo "<pre>";
        // print_r($memberprofile);
        // print_r($memberemployment);
        // print_r($memberspouse);
        // echo "</pre>";

        return view::make('pages.members.memberprofile')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('member_id', $member_id)
            ->with('userinfo', $userinfo)
            ->with('memberprofile', $memberprofile)
            ->with('memberspouse', $memberspouse)
            ->with('memberemployment', $memberemployment);
            // ->with('member_comakers', $member_comakers);
    }

    public function updatemembersave($domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $user_id = Input::get('member_id');
        $user = new User;
        $spouse = new UserSpouse;
        $employment = new UserEmployment;

        if ($this->updateData($domain, $user_id, $user, $spouse, $employment)){
            Session::put('flash_message', 'Successfully updated.');
            return Redirect::route('getmemberprofile', array('domain' => $domain, 'user_id' => $currentuser, 'member_id' => $user_id));
        }else{
            $errors = new MessageBag(['member' => ['There was an error in updating the profile.']]);
            return Redirect::route('getmemberprofile', array('domain' => $domain, 'user_id' => $currentuser, 'member_id' => $user_id))->withErrors($errors);
        }
    }

    public function updateData($domain, $user_id, $user, $spouse, $employment){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $user_id = Input::get('member_id');
        $user = new User;
        $spouse = new UserSpouse;
        $employment = new UserEmployment;

        $avatar = Input::file('user_pic');
        $ext = $avatar->guessClientExtension();
        $filename = "avatar.".$ext;
        $destination = 'local/storage/app/members/'.$user_id;
        $storage = 'members/'.$user_id;
        $avatar->storeAs($storage, $filename);

        $user = DB::table('users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $user_id)
            ->update(['user_fname' =>  Input::get('member_fname'),
                    'user_mname' =>  Input::get('member_mname'),
                    'user_lname' =>  Input::get('member_lname'),
                    'user_sex' =>  Input::get('member_sex'),
                    'user_civilstatus' => Input::get('member_civilstatus'),
                    'user_bday' => Input::get('member_bday'),
                    'user_bplace' => Input::get('member_bplace'),
                    'user_address' => Input::get('member_address'),
                    'user_mobile' => Input::get('member_mobile'),
                    'user_mobile' => Input::get('member_mobile'),
                    'user_landline' => Input::get('member_landline'),
                    'user_email' =>  Input::get('member_email'),
                    'user_zip' => Input::get('member_zip'),
                    'user_nationality' => Input::get('member_nationality'),
                    'user_religion' => Input::get('member_religion'),
                    'user_photo' => $destination."/".$filename
                    ]
            );
            
        $spouse = DB::table('user_spouses')
            ->where('coop_id', $coop_id)
            ->where('user_id', $user_id)
            ->update(['user_spouse_name' => Input::get('member_spouse_name'),
                    'user_spouse_occupation' => Input::get('member_spouse_occupation'),
                    'user_spouse_contact' => Input::get('member_spouse_contact')]
                );

        $user_emp_sector = Input::get('member_emp_sector');
        if ($user_emp_sector == "Others"){
            $user_emp_sector = Input::get('member_empsector_other');
        }else{
            $user_emp_sector = Input::get('member_emp_sector');
        }
        $employment = DB::table('user_employments')
            ->where('coop_id', $coop_id)
            ->where('user_id', $user_id)
            ->update(['user_emp_sector' => $user_emp_sector,
                    'user_emp_occupation' => Input::get('member_emp_occupation'),
                    'user_emp_name' => Input::get('member_emp_name'),
                    'user_emp_address' => Input::get('member_emp_address'),
                    'user_emp_contact' => Input::get('member_emp_contact')]
                );
    
        return true;
    }

    public function memberloanbook($domain, $user_id, $member_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $totalshare = 0; 
        // $loanhistory = DB::table('loans')
        //     ->where('coop_id', $coop_id)
        //     ->where('user_id', $member_id)
        //     ->where('user_loan_status', "1")
        //     ->get()->toArray();

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        $activeloans = DB::table('loan_users')
            ->select('loan_users.loan_user_id', 'loans.loan_name', 'loan_users.loan_user_amount', 'loan_users.loan_user_rate', 'loan_users.loan_user_amortization', 'loan_users.loan_user_terms', 'loan_users.loan_user_duration', 'loan_users.loan_user_termstart', 'loan_users.loan_user_termend', 'loan_users.loan_user_request', 'loan_request_desc')
            ->join('cooperatives', 'cooperatives.coop_id', 'loan_users.coop_id')
            ->join('loans', 'loan_users.loan_id', 'loans.loan_id')
            ->join('users', 'loan_users.user_id', 'users.user_id')
            ->join('loan_requests', 'loan_requests.loan_request_id', 'loan_users.loan_user_request')
            // ->join('loan_rates', 'loan_rates.loan_id', 'loans.loan_id')
            ->where('loan_users.coop_id', $coop_id)
            ->where('loan_users.user_id', $member_id)
            ->where('loan_users.loan_user_request', 2)
            ->get()->toArray();

        $allloans = DB::table('loan_users')
            ->select('loan_users.loan_user_id', 'loans.loan_name', 'loan_users.loan_user_amount', 'loan_users.loan_user_rate', 'loan_users.loan_user_amortization', 'loan_users.loan_user_terms', 'loan_users.loan_user_duration', 'loan_users.loan_user_termstart', 'loan_users.loan_user_termend', 'loan_users.loan_user_request', 'loan_request_desc')
            ->join('cooperatives', 'cooperatives.coop_id', 'loan_users.coop_id')
            ->join('loans', 'loan_users.loan_id', 'loans.loan_id')
            ->join('users', 'loan_users.user_id', 'users.user_id')
            ->join('loan_requests', 'loan_requests.loan_request_id', 'loan_users.loan_user_request')
            // ->join('loan_rates', 'loan_rates.loan_id', 'loans.loan_id')
            ->where('loan_users.coop_id', $coop_id)
            ->where('loan_users.user_id', $member_id)
            ->get()->toArray();

        $membershare = DB::table('share_capitals')
            ->select('share_amount')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();

        $memberprofile = json_decode(json_encode($memberprofile), True);
        $activeloans = json_decode(json_encode($activeloans), True);
        $allloans = json_decode(json_encode($allloans), True);
        $membershare = json_decode(json_encode($membershare), True);

        foreach($membershare as $share => $key){
            $totalshare += (int)$key['share_amount'];
        }

        for($i=0; $i<sizeof($activeloans); $i++){
            foreach ($activeloans as $loans => $key) {
                $activeloans[$i]['loan_user_termstart'] = date('M d, Y', strtotime($key['loan_user_termstart']));
                $activeloans[$i]['loan_user_termend'] = date('M d, Y', strtotime($key['loan_user_termend']));
            }
        }

        for($i=0; $i<sizeof($allloans); $i++){
            foreach ($allloans as $loans => $key) {
                $allloans[$i]['loan_user_termstart'] = date('M d, Y', strtotime($key['loan_user_termstart']));
                $allloans[$i]['loan_user_termend'] = date('M d, Y', strtotime($key['loan_user_termend']));
            }
        }
        
        // echo "<pre>";print_r($memberloans); echo "</pre>";
        return view::make('pages.members.loanbook')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('member_id', $member_id)
            ->with('activeloans', $activeloans)
            ->with('allloans', $allloans)
            ->with('totalshare', $totalshare)
            ->with('memberprofile', $memberprofile);
    }

}


