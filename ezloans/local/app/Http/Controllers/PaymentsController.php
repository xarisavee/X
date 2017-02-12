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
use App\LoanPayment;
use App\Transaction;
use App\TransactionDetails;
use App\ShareCapital;
use Hash;
use Redirect;
use Flash;
use Illuminate\Support\MessageBag;

class PaymentsController extends Controller
{
    public function paymentform($domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $ornumber = $this->getORNumber($coop_id);

        // $a = \App::call('App\Http\Controllers\EqualAmortizationCalculator@equalAmortizationNoAjax');

        return view::make('pages.payments.paymentform')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('ornumber', $ornumber)
            ->with('userinfo', $userinfo);
    }

    public function loanpaymentform($domain, $user_id){
        return $this->getallmembers($domain, $user_id);
    }

    public function getORNumber($coop_id){
        $count = DB::table('transactions')
            ->where('coop_id', $coop_id)
            ->count();

        $count++;

        if($count<10){
            $ornumber = "00000".$count;
        }else if(($count>10) AND ($count<100)){
            $ornumber = "0000".$count;
        }else if(($count>100) AND ($count<1000)){
            $ornumber = "000".$count;
        }else if($count>1000){
            $ornumber = "00".$count;
        }else{
            $ornumber = "0".$count;
        }

        return $ornumber;
    }

    public function pay_searchmember(Request $request, $domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $search = $request->searchKeyword;
        $status = [];

        $users = DB::table('users')
            ->select('user_id', 'user_fname', 'user_mname', 'user_lname')
            ->where('coop_id', $coop_id)
            ->where('user_id', $search)
            // ->orWhere('user_fname', 'LIKE', '%'.$search.'%')
            // ->orWhere('user_lname', 'LIKE', '%'.$search.'%')
            ->first();

        $users = json_decode(json_encode($users), True);


        if(is_array($users)){
            return $users;
        }
        else{
            $status = "fail";
            $users[] = $status;
            return $users;
        }
            
    }

    public function searchLoan(Request $request, $domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $search = $request->searchKeyword;
        $member_id = $request->member_id;

        $loandetails = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $search)
            ->get()->toArray();

        $loandetails = json_decode(json_encode($loandetails), True);
        return $loandetails;
    }

    public function getCoopId($domain){
        $coop = DB::table('cooperatives')->select('coop_id')->where('coop_domain', $domain)->first();
        $coop = json_decode(json_encode($coop), True);
        $coop_id = $coop['coop_id'];

        return $coop_id;
    }

    public function getCurrentUser($domain, $user_id){
        $domain = $domain;
        $coop_id = $this->getCoopId($domain);

        $userinfo = DB::table('users')
                ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
                ->where('cooperatives.coop_domain', $domain)
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

    public function savepaymentform($domain, $user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $ornumber = Input::get('ornumber');
        $member_id = Input::get('transaction_idmember');

        $trans = [];
        $trans['type'] = Input::get('transaction_type');
        $trans['desc'] = Input::get('transaction_desc');
        $trans['payment'] = Input::get('transaction_payment');

        $share = new ShareCapital;
        $transaction = new Transaction;
        $transaction_details = new TransactionDetails;

        $i = 0;

        while($i < count( $trans['payment'] )){
            if($trans['type'][$i] == "ShareCapital"){
                $sharecapital_array = array(
                    'coop_id' => $coop_id,
                    'user_id' => $user_id,
                    'share_id' => $this->getShareId($coop_id, $member_id),
                    'share_amount' => $trans['payment'][$i],
                    'added_by' =>  $user_id,
                    );
                DB::table('share_capitals')->insert($sharecapital_array);
            }

            
            $transaction->coop_id = $coop_id;
            $transaction->ornumber = $ornumber;
            $transaction->user_id = $member_id;
            $transaction->added_by = $user_id;
            $transaction->save();

            $transaction_details_array = array(
                'coop_id' => $coop_id,
                'ornumber' => $ornumber,
                'user_id' => $member_id,
                'transaction_id' => $this->getTransactionId($coop_id, $member_id, $ornumber),
                'transaction_type' => $trans['desc'][$i],
                'transaction_amount' => $trans['payment'][$i],
                'added_by' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                );
            DB::table('transaction_details')->insert($transaction_details_array);

            $i++;  
        }

        return Redirect::route('paymentform', array('domain' => $domain, 'user_id' => $user_id));
        
    }

    public function getShareId($coop_id, $member_id){
        $shareid = DB::table('share_capitals')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->count();

        $shareid++;

        return $shareid;
    }

    public function paymemberloan($domain, $user_id, $member_id, $loan_user_id){
    	$domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $back = 1;

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            // ->join('user_employments', 'user_employments.user_id', 'users.user_id')
            // ->join('user_spouses', 'user_spouses.user_id', 'users.user_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        $memberprofile = json_decode(json_encode($memberprofile), True);

        return view::make('pages.payments.loanschedule')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('member_id', $member_id)
            ->with('userinfo', $userinfo)
            ->with('back', $back)
            ->with('loan_user_id', $loan_user_id)
            ->with('memberprofile', $memberprofile);
    }

    public function pay_getmemberloan($domain, $user_id, $member_id, $loan_user_id){
    	$domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

       $loanschedule = DB::table('loan_users')
       		->where('coop_id', $coop_id)
       		->where('user_id', $member_id)
       		->where('loan_user_id', $loan_user_id)
       		->get()->toArray();

       	$loanschedule = json_decode(json_encode($loanschedule), True);

        return $loanschedule;
    }

    public function countpayments($domain, $user_id, $member_id, $loan_user_id){
    	$domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

       $payments = DB::table('loan_payments')
       		->where('coop_id', $coop_id)
       		->where('user_id', $member_id)
       		->where('loan_user_id', $loan_user_id)
       		->count();

       	// $payments++;

        return $payments;
    }

    public function savepayment(Request $request, $domain, $user_id, $member_id, $loan_user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $loan_user_id = $request->loan_user_id;
        $payment_amount = $request->payment_amount;

        $pay = new LoanPayment;
        $transaction = new Transaction;

        $table = "loan_payments";
        $pay->coop_id = $coop_id;
        $pay->user_id = $member_id;
        $pay->loan_user_id = $loan_user_id;
        $pay->loan_id = "2";
        $pay->loan_payment_id = $this->getPaymentId($coop_id, $member_id, $loan_user_id, $table);
        $pay->loan_payment_amount = $payment_amount;
        $pay->added_by = $user_id;

        $table = "transactions";
        $transaction->coop_id = $coop_id;
        $transaction->ornumber = Input::get('ornumber');
        $transaction->transaction_id = $this->getTransactionId($coop_id, $member_id, $loan_user_id, $table);
        $transaction->transaction_type = "Loan Payment";
        $transaction->transaction_amount = $payment_amount;
        $transaction->added_by = $user_id;
        // return $transaction;
        // return $transaction;
        // return $payment_amount;
        if($this->saveTransaction($pay, $transaction)){
            return 1;
        // return Redirect::route('paymentsviewmemberloans', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $currentuser, 'loan_user_id', $loan_user_id));
        }else{
            return 0;
        }

    }

    public function getPaymentId($coop_id, $member_id, $loan_user_id, $table){
        $payment_id = DB::table($table)
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->count();
        $payment_id++;

        return $payment_id;
    }

    public function getTransactionId($coop_id, $member_id, $ornumber){
        $trans_id = DB::table('transaction_details')
            ->where('coop_id', $coop_id)
            ->where('ornumber', $ornumber)
            ->count();
        $trans_id++;

        return $trans_id;
    }

    public function saveTransaction($pay, $transaction){
        $pay->save();
        $transaction->save();
        return true;
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
        return view::make('pages.payments.viewallmembers')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('checkLoans', $checkLoans)
            ->with('memberlist', $memberlist);
    }

    public function memberloanpaymentform($domain, $user_id, $member_id){
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

        $membershare = DB::table('share_capitals')
            ->select('share_amount')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->get()->toArray();

        $memberprofile = json_decode(json_encode($memberprofile), True);
        $memberloans = json_decode(json_encode($memberloans), True);
        $membershare = json_decode(json_encode($membershare), True);

        foreach($membershare as $share => $key){
            $totalshare += (int)$key['share_amount'];
        }

        foreach ($memberloans as $loans => $key) {
            $memberloans[0]['loan_user_termstart'] = date('M d, Y', strtotime($key['loan_user_termstart']));
            $memberloans[0]['loan_user_termend'] = date('M d, Y', strtotime($key['loan_user_termend']));
        }
        
        // echo "<pre>";print_r($memberloans); echo "</pre>";
        return view::make('pages.payments.loanbook')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('member_id', $member_id)
            ->with('memberloans', $memberloans)
            ->with('totalshare', $totalshare)
            ->with('memberprofile', $memberprofile);
    }

    public function memberloanpaymentformschedule($domain, $user_id, $member_id, $loan_user_id){
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);

        $datepaid = Input::get('transaction_date');
        $amountpaid = Input::get('transaction_amount');

        $loanpayment = new LoanPayment;
        $transaction = new Transaction;
        $transactiondetails = new TransactionDetails;

        $loanpaymentid = $this->getLoanPaymentId($coop_id, $member_id, $loan_user_id);
        $lastpaid = $this->getLastPaid($coop_id, $member_id, $loan_user_id);
        $ornumber = $this->getORNumber($coop_id);

        $loanpayment->coop_id = $coop_id;
        $loanpayment->user_id = $member_id;
        $loanpayment->loan_id = 1;
        $loanpayment->loan_user_id = $loan_user_id;
        $loanpayment->loan_payment_id = $loanpaymentid;
        $loanpayment->loan_payment_date = $datepaid;
        $loanpayment->loan_payment_amount = $amountpaid;
        $loanpayment->added_by = $user_id;

        if($loanpaymentid == 1){
            $loanpayment->loan_payment_totalpaid = $amountpaid;
        }else{
            $loanpayment->loan_payment_totalpaid = $lastpaid+$amountpaid;
        }

        $transaction->coop_id = $coop_id;
        $transaction->ornumber = $ornumber;
        $transaction->user_id = $member_id;
        $transaction->added_by = $user_id;

        $transactiondetails->coop_id = $coop_id;
        $transactiondetails->ornumber = $ornumber;
        $transactiondetails->user_id = $member_id;
        $transactiondetails->transaction_id = $this->getTransactionId($coop_id, $member_id, $ornumber);
        $transactiondetails->transaction_type = "Loan Payment for Loan ".$loan_user_id;
        $transactiondetails->transaction_amount = $amountpaid;
        $transactiondetails->added_by = $user_id;
        $transactiondetails->created_at = Carbon::now();
        $transactiondetails->updated_at = Carbon::now();

        $loanpayment->save();
        $transaction->save();
        $transactiondetails->save();


        return Redirect::route('memberloanpaymentformschedule', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id, 'loan_user_id' => $loan_user_id));
        
        
    }

    public function getLoanPaymentId($coop_id, $member_id, $loan_user_id){
        $loanpaymentid = DB::table('loan_payments')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->count();
        $loanpaymentid++;

        return $loanpaymentid;
    }

    public function getLastPaid($coop_id, $member_id, $loan_user_id){
        $lastpayment = 0;
        $lastpaid = DB::table('loan_payments')
            ->select('loan_payment_amount')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->get()->toArray();

        $lastpaid = json_decode(json_encode($lastpaid), True);

        foreach($lastpaid as $paid => $key){
            $lastpayment += (int)$key['loan_payment_amount'];
        }

        return $lastpayment;

    }

}
