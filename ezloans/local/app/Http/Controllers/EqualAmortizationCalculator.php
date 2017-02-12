<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EqualAmortizationCalculator extends Controller
{

    public function savesched($domain, $user_id, $member_id, $loan_user_id){
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

        $amount = $userdetails['loan_user_amount'];
        $rate = $userdetails['loan_user_rate'];
        $terms = $userdetails['loan_user_terms'];
        $duration = $userdetails['loan_user_duration'];
        $releaseDate = $userdetails['loan_user_termstart'];
        $interestMethod = $userdetails['loan_user_interest_method'];
        $accumulation = $userdetails['loan_user_accumulation'];
        $repayment = $userdetails['loan_user_repayment'];
        $retentionFee = $userdetails['loan_user_retention'];
        $processingFee = $userdetails['loan_user_processing'];
        $loaninstallment = $userdetails['loan_user_amortization'];
        $termduration = 0;
        $rateaccumulated = 0;
        $startdate = "";
        $dateInterval = 0;

        $effectiveDuration = $this->getEffectiveDuration($duration, $terms);
        $effectiveTerms = $this->getEffectiveTerms($terms, $duration);
        $effectiveRate = $this->getEffectiveRate($rate, $accumulation);
        $effectiveRepayment = $this->getEffectiveRepayment($repayment, $effectiveTerms, $releaseDate, $duration, $terms);
        $compounding = $this->getCompounding($accumulation);
        // return $effectiveRepayment;
      
        $terms = $effectiveRepayment;

        $loaninstallment = $this->getLoanInstallment($effectiveDuration, $amount, $effectiveRate, $compounding, $effectiveRepayment, $rate);
        $interestamt = $this->getInterestAmount($amount, $rate, $effectiveDuration, $compounding);
        $monthlyinterest = $this->getMonthlyInterest($interestamt, $effectiveRepayment);
        $date = $this->getSchedule($releaseDate, $repayment, $terms);
        $schedule = $this->getAmortizationSchedule($loaninstallment, $monthlyinterest, $date, $terms, $amount, $interestamt, $effectiveRate, $effectiveDuration, $effectiveRepayment);

        return $this->saveSchedDetails($schedule, $coop_id, $member_id, $loan_user_id, $domain, $user_id);
    }

    public function saveSchedDetails($schedule, $coop_id, $member_id, $loan_user_id, $domain, $user_id){
        // echo "<pre>"; print_r($schedule);  echo "</pre>";
        $sched = new LoanSchedule;
        $num_elements = 0;

        while($num_elements < sizeof($schedule)){
            $schedule_array = array(
                'coop_id'           => $coop_id,
                'user_id'           => $member_id,
                'loan_user_id'      => $loan_user_id,
                'loan_schedule_id'        => $schedule[$num_elements][0],
                'loan_schedule_date'      => $schedule[$num_elements][1],
                'loan_schedule_amount'   => $schedule[$num_elements][5],
                'loan_schedule_fee'       => "0",
                'loan_schedule_penalty'   => "0"
            );
            DB::table('loan_schedules')->insert($schedule_array);
            $num_elements++; 
        }

        // echo "<pre>"; print_r($schedule);  echo "</pre>";

        return Redirect::route('viewmemberloanbook', array('domain' => $domain, 'user_id' => $user_id, 'member_id' => $member_id));
    }

    public function payeqequalAmortizationNoAjax($userdetails){
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

        $amount = $userdetails['loan_user_amount'];
        $rate = $userdetails['loan_user_rate'];
        $terms = $userdetails['loan_user_terms'];
        $duration = $userdetails['loan_user_duration'];
        $releaseDate = $userdetails['loan_user_termstart'];
        $interestMethod = $userdetails['loan_user_interest_method'];
        $accumulation = $userdetails['loan_user_accumulation'];
        $repayment = $userdetails['loan_user_repayment'];
        $retentionFee = $userdetails['loan_user_retention'];
        $processingFee = $userdetails['loan_user_processing'];
        $loaninstallment = $userdetails['loan_user_amortization'];
        $termduration = 0;
        $rateaccumulated = 0;
        $startdate = "";
        $dateInterval = 0;

        $effectiveDuration = $this->getEffectiveDuration($duration, $terms);
        $effectiveTerms = $this->getEffectiveTerms($terms, $duration);
        $effectiveRate = $this->getEffectiveRate($rate, $accumulation);
        $effectiveRepayment = $this->getEffectiveRepayment($repayment, $effectiveTerms, $releaseDate, $duration, $terms);

        // return $effectiveRepayment;
      
        $terms = $effectiveRepayment;

        $loaninstallment = $this->getLoanInstallment($rate, $effectiveDuration, $amount, $effectiveRepayment);
        $interestamt = $this->getInterestAmount($amount, $rate, $effectiveDuration);
        $monthlyinterest = $this->getMonthlyInterest($interestamt, $effectiveRepayment);
        $date = $this->getSchedule($releaseDate, $repayment, $terms);
        $schedule = $this->getAmortizationSchedule($loaninstallment, $monthlyinterest, $date, $terms, $amount);
        
        return $this->paymemberloanbook($domain, $user_id, $member_id, $loan_user_id, $schedule);
    }

    public function getPendingDues($domain, $user_id, $member_id, $loan_user_id){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $date = Carbon::now();
        $payment = 5000;

        // echo $loan_user_id;
        $pendingpayments = DB::table('loan_schedules')
            // ->join('loan_payments', 'loan_payments.loan_user_id', 'loan_payments.loan_user_id')
            ->where('loan_schedules.coop_id', $coop_id)
            ->where('loan_schedules.user_id', $member_id)
            ->where('loan_schedules.loan_user_id', $loan_user_id)
            ->get()->toArray();

        $loandetails = DB::table('loan_users')
            ->where('coop_id', $coop_id)
            ->where('user_id', $member_id)
            ->where('loan_user_id', $loan_user_id)
            ->first();

        $loandetails = json_decode(json_encode($loandetails), True);
        $pendingpayments = json_decode(json_encode($pendingpayments), True);

        $amount = $loandetails['loan_user_amount'];
        $rate = $loandetails['loan_user_rate'];
        $effectiveDuration = $this->getEffectiveDuration($loandetails['loan_user_duration'], $loandetails['loan_user_terms']);
        $pendingdues = [];

        for($i=0; $i<sizeof($pendingpayments); $i++){
            
            if($date <= $pendingpayments[$i]['loan_schedule_date']){
                $pendingdues[0]['principal'] = $amount;
                $pendingdues[0]['interest'] = $this->getInterestAmount($pendingdues[0]['principal'], $rate, $effectiveDuration);
                $pendingdues[0]['fees'] = 0;
                $pendingdues[0]['penalty'] = 0;
                $pendingdues[0]['total'] = floatval($pendingdues[0]['principal'] + $pendingdues[0]['interest'] + $pendingdues[0]['fees'] + $pendingdues[0]['penalty']);

                $pendingdues[1]['principal'] = 0;
                $pendingdues[1]['interest'] = $this->getInterestAmount($amount = 0, $rate, $effectiveDuration);
                $pendingdues[1]['fees'] = 0;
                $pendingdues[1]['penalty'] = 0;
                $pendingdues[1]['total'] = floatval($pendingdues[1]['principal'] + $pendingdues[1]['interest'] + $pendingdues[1]['fees'] + $pendingdues[1]['penalty']);

                $pendingdues[2]['principal'] = 0;
                $pendingdues[2]['interest'] = $this->getInterestAmount($amount = 0, $rate, $effectiveDuration);
                $pendingdues[2]['fees'] = 0;
                $pendingdues[2]['penalty'] = 0;
                $pendingdues[2]['total'] = floatval($pendingdues[2]['principal'] + $pendingdues[2]['interest'] + $pendingdues[2]['fees'] + $pendingdues[2]['penalty']);

                $pendingdues[3]['duedate'] = date('M d, Y', strtotime($pendingpayments[$i]['loan_schedule_date'])); 
                $pendingdues[3]['interest'] =  $this->getInterestAmount($pendingpayments[$i]['loan_schedule_amount'], $rate, $effectiveDuration);
                $pendingdues[3]['principal'] = floatval( $pendingpayments[$i]['loan_schedule_amount'] -  $pendingdues[3]['interest']);
                $pendingdues[3]['fees'] = 0;
                $pendingdues[3]['penalty'] = 0;
                $pendingdues[3]['total'] = floatval( $pendingdues[3]['principal'] +  $pendingdues[3]['interest'] + $pendingdues[3]['fees'] + $pendingdues[3]['penalty']);

                $pendingdues[4]['duedate'] = date('M d, Y', strtotime($pendingpayments[$i]['loan_schedule_date'])); 
                $pendingdues[4]['interest'] =  0;
                $pendingdues[4]['principal'] = 0;
                $pendingdues[4]['fees'] = 0;
                $pendingdues[4]['penalty'] = 0;
                $pendingdues[4]['total'] = 0;

                $pendingdues[5]['duedate'] = date('M d, Y', strtotime($pendingpayments[$i]['loan_schedule_date'])); 
                $pendingdues[5]['interest'] =  0;
                $pendingdues[5]['principal'] = 0;
                $pendingdues[5]['fees'] = 0;
                $pendingdues[5]['penalty'] = 0;
                $pendingdues[5]['total'] = 0;
                break;
            }
            
        }

        return $pendingdues;

        // echo "<pre>"; print_r($pendingdues); echo "</pre>";
    }

    public function paymemberloanbook($domain, $user_id, $member_id, $loan_user_id, $schedule){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $totalshare = 0; 
        $back= 1;

        $enablemakepayments = 0;

        if($member_id == "1" || $member_id == "2" ){
            $enablemakepayments = 1;
        }

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        $memberloans = DB::table('loan_users')
            ->join('loans', 'loans.coop_id', 'loan_users.coop_id')
            ->join('loan_requests', 'loan_users.loan_user_request', 'loan_requests.loan_request_id')
            ->where('loan_users.coop_id', $coop_id)
            ->where('loan_users.user_id', $member_id)
            ->where('loan_users.loan_user_id', $loan_user_id)
            ->where('loan_users.loan_user_status', 1)
            ->first();

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
        
        $pendingdues = $this->getPendingDues($domain, $user_id, $member_id, $loan_user_id);

        // echo "<pre>";print_r($pendingdues);echo "</pre>";
        return view::make('pages.payments.loanbookschedule')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('schedule', $schedule)
            ->with('member_id', $member_id)
            ->with('loan_user_id', $loan_user_id)
            ->with('memberloans', $memberloans)
            ->with('totalshare', $totalshare)
            ->with('pendingdues', $pendingdues)
            ->with('ornumber', $ornumber)
            ->with('enablemakepayments',  $enablemakepayments)
            ->with('memberprofile', $memberprofile);
    }

	public function equalAmortizationNoAjax($userdetails){
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

        $amount = $userdetails['loan_user_amount'];
        $rate = $userdetails['loan_user_rate'];
        $terms = $userdetails['loan_user_terms'];
        $duration = $userdetails['loan_user_duration'];
        $releaseDate = $userdetails['loan_user_termstart'];
        $interestMethod = $userdetails['loan_user_interest_method'];
        $accumulation = $userdetails['loan_user_accumulation'];
        $repayment = $userdetails['loan_user_repayment'];
        $retentionFee = $userdetails['loan_user_retention'];
        $processingFee = $userdetails['loan_user_processing'];
        $loaninstallment = $userdetails['loan_user_amortization'];
        $termduration = 0;
        $rateaccumulated = 0;
        $startdate = "";
        $dateInterval = 0;

        $effectiveDuration = $this->getEffectiveDuration($duration, $terms);
        $effectiveTerms = $this->getEffectiveTerms($terms, $duration);
        $effectiveRate = $this->getEffectiveRate($rate, $accumulation);
        $effectiveRepayment = $this->getEffectiveRepayment($repayment, $effectiveTerms, $releaseDate, $duration, $terms);

        // return $effectiveRepayment;
      
        $terms = $effectiveRepayment;

        $loaninstallment = $this->getLoanInstallment($rate, $effectiveDuration, $amount, $effectiveRepayment);
        $interestamt = $this->getInterestAmount($amount, $rate, $effectiveDuration);
        $monthlyinterest = $this->getMonthlyInterest($interestamt, $effectiveRepayment);
        $date = $this->getSchedule($releaseDate, $repayment, $terms);
        $schedule = $this->getAmortizationSchedule($loaninstallment, $monthlyinterest, $date, $terms, $amount);
        
        return $this->memberloanbook($domain, $user_id, $member_id, $loan_user_id, $schedule);
	}

	public function memberloanbook($domain, $user_id, $member_id, $loan_user_id, $schedule){
        $domain = $domain;
        $currentuser = $user_id;
        $coop_id = $this->getCoopId($domain);
        $userinfo = $this->getCurrentUser($domain, $user_id);
        $member_id = $member_id;
        $totalshare = 0; 
        $back= 1;

        $memberprofile = DB::table('users')
            ->join('cooperatives', 'cooperatives.coop_id', 'users.coop_id')
            ->where('users.coop_id', $coop_id)
            ->where('users.user_id', $member_id)
            ->get()->toArray();

        $memberloans = DB::table('loan_users')
        	->join('loans', 'loans.coop_id', 'loan_users.coop_id')
        	->join('loan_requests', 'loan_users.loan_user_request', 'loan_requests.loan_request_id')
            ->where('loan_users.coop_id', $coop_id)
            ->where('loan_users.user_id', $member_id)
            ->where('loan_users.loan_user_id', $loan_user_id)
            ->where('loan_users.loan_user_status', 1)
            ->first();

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
        
        return view::make('pages.members.loanbookschedule')
            ->with('domain', $domain)
            ->with('user_id', $user_id)
            ->with('userinfo', $userinfo)
            ->with('schedule', $schedule)
            ->with('memberloans', $memberloans)
            ->with('totalshare', $totalshare)
            ->with('memberprofile', $memberprofile);
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

    public function equalAmortization(Request $request){
    	$amount = $request->Amount;
        $rate = $request->Rate;
        $terms = $request->Terms;
        $duration = $request->Duration;
        $releaseDate = $request->ReleaseDate;
        $interestMethod = $request->interestMethod;
        $accumulation = $request->Accumulation;
        $repayment = $request->Repayment;
        $retentionFee = $request->RetentionFee;
        $processingFee = $request->ProcessingFee;
        $loaninstallment = $request->LoanInstallment;
        $termduration = 0;
        $rateaccumulated = 0;
        $startdate = "";
        $dateInterval = 0;

        $effectiveDuration = $this->getEffectiveDuration($duration, $terms);
        $effectiveTerms = $this->getEffectiveTerms($terms, $duration);
        $effectiveRate = $this->getEffectiveRate($rate, $accumulation);
        $effectiveRepayment = $this->getEffectiveRepayment($repayment, $effectiveTerms, $releaseDate, $duration, $terms);
        $compounding = $this->getCompounding($accumulation);
        // return $effectiveRepayment;
      
        $terms = $effectiveRepayment;

        $loaninstallment = $this->getLoanInstallment($effectiveDuration, $amount, $effectiveRate, $compounding, $effectiveRepayment);
        $interestamt = $this->getInterestAmount($amount, $rate, $effectiveDuration, $compounding);
        $monthlyinterest = $this->getMonthlyInterest($interestamt, $effectiveRepayment);
        $date = $this->getSchedule($releaseDate, $repayment, $terms);
        $schedule = $this->getAmortizationSchedule($loaninstallment, $monthlyinterest, $date, $terms, $amount, $interestamt, $effectiveRate);
        return $schedule;
    }

    public function getAmortizationSchedule($loaninstallment, $monthlyinterest, $date, $terms, $amount, $interestamt, $effectiveRate){
    	$loanschedule = [];
        $amortization = [];
        $principal = [];
        $interest = [];
        $balance = [];
        $month = [];
        $tempbal = [];

        for($i = 0; $i < $terms; $i++){   
            if($i == 0){
                $month[$i] = $i+1;
                $amortization[$i] = round($loaninstallment, 2);
                $tempbal[$i] = round(sprintf('%f', $amount), 2);
                $interest[$i] = round($effectiveRate*$tempbal[$i], 2);
                $principal[$i] = round(sprintf('%f', $amortization[$i]-$interest[$i]), 2);
                $balance[$i] = round(sprintf('%f', $tempbal[$i]-$principal[$i]), 2);
                
            }else{
                $month[$i] = $i+1;
                $amortization[$i] = round($loaninstallment, 2);
                $tempbal[$i] = round(sprintf('%f', $balance[$i-1]), 2);
                $interest[$i] = round($effectiveRate*$balance[$i-1], 2); 
                $principal[$i] = round(sprintf('%f', $amortization[$i]-$interest[$i]), 2);
                $balance[$i] = round(sprintf('%f', $tempbal[$i]-$principal[$i]), 2);
                        
            }
        }

        $loanschedule['month'] = $month;
        $loanschedule['date'] = $date;
        $loanschedule['balance'] = $balance;
        $loanschedule['principal'] = $principal;
        $loanschedule['interest'] = $interest;
        $loanschedule['amortization'] = $amortization;
        // $loanschedule['tempbal'] = $tempbal;
        
        $schedule= [];
        foreach ($loanschedule as $sched) {
            foreach ($sched as $key => $value) {
                $schedule[$key][] = $value; 
            }
        }

        // session()->put('amortization', $amortization[0]);

        $loanschedule = json_decode(json_encode($loanschedule), True);
        $schedule = json_decode(json_encode($schedule), True);
        return $schedule;
    }

    public function getLoanInstallment($effectiveDuration, $amount, $effectiveRate, $compounding, $effectiveRepayment){
    	// $loaninstallment = ((($amount*(($effectiveRate/100)*$effectiveDuration))+$amount) / ($effectiveRepayment));
    	// $loaninstallment = ($amount * pow((1 + $effectiveRate), ($compounding*$effectiveDuration))) / $effectiveRepayment;
    	// $loaninstallment = (($effectiveRate*pow((1+$effectiveRate), $effectiveRepayment)) / pow((1+$effectiveRate), $effectiveRepayment) -1 ) * $amount;
    	$loaninstallment = ($effectiveRate*$amount) / (1 - pow( (1+$effectiveRate), (-$effectiveRepayment)));
    	return $loaninstallment;
    	/*$loaninstallment = ((($amount*(($effectiveRate/100)*$effectiveDuration))+$amount) / ($effectiveRepayment));
    	return $loaninstallment*/;
    }

    public function getInterestAmount($amount, $rate, $effectiveDuration, $compounding){
    	// $interestamt = ($amount * (($rate/100))) / $effectiveDuration;
    	$interestamt = ($compounding * pow((1+$rate), 1/$compounding) - 1);
    	return $interestamt;
    }

    public function getMonthlyInterest($interestamt, $effectiveRepayment){
    	$monthlyinterest = $interestamt / $effectiveRepayment;
    	return $monthlyinterest;
    }

    public function getEffectiveDuration($duration, $terms){
    	switch ($duration) {
    		case 'Months':
    			$effectiveDuration = $terms / 12;
    			break;

    		case 'Years':
    			$effectiveDuration = $terms;
    			
    			break;

    		default:
    			$effectiveDuration = 1;
    			break;
    	}

    	return ($effectiveDuration);
    }

    public function getEffectiveTerms($terms, $duration){
    	switch ($duration) {
    		case 'Years':
    			$effectiveTerms = $terms * 12;
    			break;
    		
    		case 'Months':
    			$in_years = (int)$terms / 12;
    			$has_months = $terms%12;
    			// $in_months = $terms/$has_months;

    			if($has_months == 0){
    				$effectiveTerms = $in_years * 12;
    			}else{
    				$effectiveTerms = $in_years * 12;
    				$effectiveTerms = $effectiveTerms + $has_months;
    			}
    			$effectiveTerms = ($terms/12);
    			break;
    	}

    	return $effectiveTerms;
    }

    public function getEffectiveRepayment($repayment, $effectiveTerms, $releaseDate, $duration, $terms){
    	if($duration == "Years"){
			switch ($repayment) {
				case 'Daily':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$dateInterval = floor($dateInterval / (60 * 60 * 24));
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Weekly':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 7;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Biweekly':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$sem1 = strtotime($releaseDate);
	    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+2 weeks")));
	    			$semcount = $sem2 - $sem1;
	    			$sems = floor($semcount / (60 * 60 * 24));

	    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Monthly':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 30;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Bimonthly':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$sem1 = strtotime($releaseDate);
	    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+2 months")));
	    			$semcount = $sem2 - $sem1;
	    			$sems = floor($semcount / (60 * 60 * 24));

	    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Quarterly':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					// $dateInterval = $startdate;
					$sem1 = strtotime($releaseDate);
	    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+4 months")));
	    			$semcount = $sem2 - $sem1;
	    			$sems = floor($semcount / (60 * 60 * 24));

	    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Semi-annually':
					$startdate = strtotime($releaseDate);
					$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." year")));
					$dateInterval = $enddate - $startdate;
					$sem1 = strtotime($releaseDate);
	    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+6 months")));
	    			$semcount = $sem2 - $sem1;
	    			$sems = floor($semcount / (60 * 60 * 24));

	    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
					$effectiveRepayment = ($dateInterval);
					break;

				case 'Annually':
					$effectiveRepayment = $terms*1;
					break;
			}

			return floor($effectiveRepayment);
    	}
    	else if($duration == "Months"){
    		$in_y = $effectiveTerms * 12;
    		$yearcount = floor($terms / 12);
    		$has_m = $terms / 12;
    		$has = $terms % 12;

	    		if(($terms == 12) OR (($has == 0) AND ($has_m != 0))){ // in months, whole year
		    		switch ($repayment) {
						case 'Daily':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							// $dateInterval = $startdate;
							$dateInterval = floor($dateInterval / (60 * 60 * 24));
							$effectiveRepayment = ($dateInterval);
							break;

						case 'Weekly':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							// $dateInterval = $startdate;
							$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 7;
							$effectiveRepayment = ($dateInterval);
							break;

						case 'Biweekly':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							// $dateInterval = $startdate;
							$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 14;
							$effectiveRepayment = ($dateInterval);
							break;

						case 'Monthly':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							// $dateInterval = $startdate;

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 30;
							$effectiveRepayment = ($dateInterval);
							break;

						case 'Bimonthly':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							
							$quarter1 = strtotime($releaseDate);
			    			$quarter2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+2 months")));
			    			$quartercount = $quarter2 - $quarter1;
			    			$quarters = floor($quartercount / (60 * 60 * 24));

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $quarters;

							$effectiveRepayment = ($dateInterval);
							break;

						case 'Quarterly':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							
							$quarter1 = strtotime($releaseDate);
			    			$quarter2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+3 months")));
			    			$quartercount = $quarter2 - $quarter1;
			    			$quarters = floor($quartercount / (60 * 60 * 24));

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $quarters;
							$effectiveRepayment = ($dateInterval);
							break;

						case 'Semi-annually':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;

							$sem1 = strtotime($releaseDate);
			    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+6 months")));
			    			$semcount = $sem2 - $sem1;
			    			$sems = floor($semcount / (60 * 60 * 24));

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
			    			$effectiveRepayment = $dateInterval;
							break;

						case 'Annually':
							$startdate = strtotime($releaseDate);
							$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms." months")));
							$dateInterval = $enddate - $startdate;
							$sem1 = strtotime($releaseDate);
			    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+1 year")));
			    			$semcount = $sem2 - $sem1;
			    			$sems = floor($semcount / (60 * 60 * 24));

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
							$effectiveRepayment = ($dateInterval);
							break;
					}

					return floor($effectiveRepayment);
		    	}
		    	else if(($has_m > 1) AND ($terms > 12)){ // in months, lagpas 1 year
		    		$in_years = $effectiveTerms*12;
	    			$in_months = floor(floatval($in_years/12));
	    			$excessmonths = $in_years%12;

					switch ($repayment) {

			    		case 'Daily':
			    			//add year
			    			$startdate = date('Y-m-d', strtotime($releaseDate));
			    			/*$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$yearcount ." years")));
			    			$enddate = date('Y-m-d', $enddate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$has_m ." months")));
			    			$enddate = date('Y-m-d', $enddate);*/
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
			    			$enddate = date('Y-m-d', $enddate);

			    			// $enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$excessmonths ." months")));
			    			$dateInterval = strtotime($enddate) - strtotime($startdate);
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24));
			    			$effectiveRepayment = $dateInterval;
			    			// $dateInterval = $yearcount;
			    			break;

			    		case 'Weekly':
			    			//add year
			    			$startdate = date('Y-m-d', strtotime($releaseDate));
			    			/*$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$yearcount ." years")));
			    			$enddate = date('Y-m-d', $enddate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$has_m ." months")));
			    			$enddate = date('Y-m-d', $enddate);*/
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
			    			$enddate = date('Y-m-d', $enddate);

			    			// $enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$excessmonths ." months")));
			    			$dateInterval = strtotime($enddate) - strtotime($startdate);
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 7;
			    			$effectiveRepayment = $dateInterval;
			    			break;

			    		case 'Biweekly':
			    			$startdate = date('Y-m-d', strtotime($releaseDate));
			    			/*$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$yearcount ." years")));
			    			$enddate = date('Y-m-d', $enddate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$has_m ." months")));
			    			$enddate = date('Y-m-d', $enddate);*/
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
			    			$enddate = date('Y-m-d', $enddate);

			    			// $enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$excessmonths ." months")));
			    			$dateInterval = strtotime($enddate) - strtotime($startdate);
			    			// $dateInterval = $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 14;
			    			$effectiveRepayment = ($dateInterval);
			    			break;

			    		case 'Monthly':
			    			$startdate = date('Y-m-d', strtotime($releaseDate));
			    			/*$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$yearcount ." years")));
			    			$enddate = date('Y-m-d', $enddate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$has_m ." months")));
			    			$enddate = date('Y-m-d', $enddate);*/
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
			    			$enddate = date('Y-m-d', $enddate);

			    			// $enddate = strtotime(date('Y-m-d', strtotime($enddate ."+".$excessmonths ." months")));
			    			$dateInterval = strtotime($enddate) - strtotime($startdate);
			    			// $dateInterval = $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 30;
			    			$effectiveRepayment = ($dateInterval);
			    			break;

			    		case 'Bimonthly':
			    			if($has_m > 1){
			    				$startdate = date('Y-m-d', strtotime($releaseDate));
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
				    			$enddate = date('Y-m-d', $enddate);
				    			$dateInterval = strtotime($enddate) - strtotime($startdate);
				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / ($effectiveTerms * 2);
				    			$effectiveRepayment = ($dateInterval);
			    			}else{
			    				$effectiveRepayment = 1;
			    			}
			    			break;

			    		case 'Quarterly':
			    			if($has_m > 1){
			    				$startdate = date('Y-m-d', strtotime($releaseDate));
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
				    			$enddate = date('Y-m-d', $enddate);
				    			$dateInterval = strtotime($enddate) - strtotime($startdate);
				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / ($effectiveTerms * 4);
				    			$effectiveRepayment = ($dateInterval);
			    			}else{
			    				$effectiveRepayment = 1;
			    			}
			    			break;

			    		case 'Semi-annually':
			    			if($has_m > 1){
			    				$startdate = date('Y-m-d', strtotime($releaseDate));
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
				    			$enddate = date('Y-m-d', $enddate);
				    			$dateInterval = strtotime($enddate) - strtotime($startdate);
				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / ($effectiveTerms * 6);
				    			$effectiveRepayment = ($dateInterval);
			    			}else{
			    				$effectiveRepayment = 1;
			    			}
			    			break;

			    		case 'Annually':
			    			if($has_m > 1){
			    				$startdate = date('Y-m-d', strtotime($releaseDate));
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$terms ." months")));
				    			$enddate = date('Y-m-d', $enddate);
				    			$dateInterval = strtotime($enddate) - strtotime($startdate);
				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 365;
				    			$effectiveRepayment = ($dateInterval);
			    			}else{
			    				$effectiveRepayment = 1;
			    			}
			    			break;
		    		}

		    		return floor($effectiveRepayment);
				}

				else if($terms < 12){// in months but less than a year

					$in_months = $effectiveTerms*12;
	    			$in_years = (int)$in_months/12;
	    			$excessmonths = $in_months%12; 
	    			$even = $terms%2;

					switch ($repayment) {
			    		case 'Daily':
			    			$startdate = strtotime($releaseDate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
			    			$dateInterval = $enddate - $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24));
			    			// $dateInterval = $startdate;
			    			/*if ($excessmonths > 0 ){
			    				$dateInterval = strtotime(date('Y-m-d', strtotime($dateInterval ."+".$excessmonths." month")));
			    				$dateInterval = floor($dateInterval / (60 * 60 * 24));
			    			}

			    			$dateInterval = $enddate - $startdate;

			    			$dateInterval = floor($dateInterval / (60 * 60 * 24));*/
			    			$effectiveRepayment = round($dateInterval);
			    			break;

			    		case 'Weekly':

			    			$startdate = strtotime($releaseDate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
			    			$dateInterval = $enddate - $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 7;
			    			$effectiveRepayment = round($dateInterval);
			    			break;

			    		case 'Biweekly':
			    			$startdate = strtotime($releaseDate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
			    			$dateInterval = $enddate - $startdate;
			    			// $dateInterval = $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 14;
			    			$effectiveRepayment = round($dateInterval);
			    			break;

			    		case 'Monthly':
			    			$startdate = strtotime($releaseDate);
			    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
			    			$dateInterval = $enddate - $startdate;
			    			// $dateInterval = $startdate;
			    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / 30;
			    			$effectiveRepayment = round($dateInterval);
			    			break;

			    		case 'Bimonthly':
			    			if(($terms%2) == 0){
			    				$in_months = $effectiveTerms*12;
				    			$in_years = (int)$in_months/12;
				    			$excessmonths = $in_months%12;

				    			$quarter1 = strtotime($releaseDate);
				    			$quarter2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+2 months")));
				    			$quartercount = $quarter2 - $quarter1;
				    			$quarters = floor($quartercount / (60 * 60 * 24));

				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $quarters;
				    			$effectiveRepayment = round($dateInterval);
			    			}
			    			else{
								$effectiveRepayment = 1;
			    			}
			    			
			    			break;

			    		case 'Quarterly':
			    			if(($terms%4) == 0){
				    			$in_months = $effectiveTerms*12;
				    			$in_years = (int)$in_months/12;
				    			$excessmonths = $in_months%12;

				    			$startdate = strtotime($releaseDate);
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
				    			$dateInterval = $enddate - $startdate;
				    			// $dateInterval = $startdate;

				    			$quarter1 = strtotime($releaseDate);
				    			$quarter2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+3 months")));
				    			$quartercount = $quarter2 - $quarter1;
				    			$quarters = floor($quartercount / (60 * 60 * 24));

				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $quarters;
				    			$effectiveRepayment = round($dateInterval);
				    		}
				    		else{
				    			$effectiveRepayment = 1;
				    		}
			    			break;

			    		case 'Semi-annually':
				    		if(($terms%4) == 0){
				    			$in_months = $effectiveTerms*12;
				    			$in_years = (int)$in_months/12;
				    			$excessmonths = $in_months%12;

				    			$startdate = strtotime($releaseDate);
				    			$enddate = strtotime(date('Y-m-d', strtotime($releaseDate ."+".$in_months ." months")));
				    			$dateInterval = $enddate - $startdate;
				    			// $dateInterval = $startdate;

				    			$sem1 = strtotime($releaseDate);
				    			$sem2 = strtotime(date('Y-m-d', strtotime($releaseDate ."+6 months")));
				    			$semcount = $sem2 - $sem1;
				    			$sems = floor($semcount / (60 * 60 * 24));

				    			$dateInterval = floor($dateInterval / (60 * 60 * 24)) / $sems;
				    			$effectiveRepayment = round($dateInterval);
				    		}
				    		else{
				    			$effectiveRepayment = 1;
				    		}
			    			break;

			    		case 'Annually':
			    			$effectiveRepayment = 1;
			    			break;
		    		}

		    		return ceil($effectiveRepayment);
				}
    	
		}
		// return $dateInterval;    		
		return floor($effectiveRepayment);
    	
    	// return $dateInterval;
    }

    public function getSchedule($releaseDate, $repayment, $terms){

    	$date = [];
    	for($i = 0; $i < $terms; $i++){   
	    	if ($repayment == "Daily") {
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+1 day"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+1 day"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Weekly"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
					$startdate = date('Y-m-d', strtotime($releaseDate ."+7 days"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+7 days"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Biweekly"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+2 week"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+2 week"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Monthly"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+1 month"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+1 month"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Bimonthly"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+2 month"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+2 month"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Quarterly"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+3 months"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+3 months"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Semi-annually"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+6 months"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+6 months"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    	else if($repayment == "Annually"){
	    		if($i == '0'){
	    			// $releaseDate = strtotime($releaseDate);
	    			$startdate = date('Y-m-d', strtotime($releaseDate ."+1 year"));
	    			$date[$i] = $startdate;
	    		}
	    		else{
	    			$startdate = date('Y-m-d', strtotime($date[$i-1] ."+1 year"));
	    			// $startdate = date('Y/m/d', $startdate);
	   	 			$date[$i] = $startdate;
	    		}
	    	}
	    }

	    return $date;
    }

    public function getEffectiveRate($rate, $accumulation){
    	switch ($accumulation) {
    		case 'Daily':
    			$effectiveRate = $rate / 365;
    			break;

			case 'Weekly':
    			$effectiveRate = $rate / 52;
    			break;

    		case 'Biweekly':
    			$effectiveRate = $rate / 26;
    			break;

    		case 'Monthly':
    			$effectiveRate = $rate / 12;
    			break;

    		case 'Bimonthly':
    			$effectiveRate = $rate / 6;
    			break;

    		case 'Quarterly':
    			$effectiveRate = $rate / 4;
    			break;

    		case 'Semi-annually':
    			$effectiveRate = $rate / 2;
    			break;

    		case 'Annually':
    			$effectiveRate = $rate / 1;
    			break;

    		default:
    			$effectiveRate = $rate / 1;
    			break;
    	}

    	$effectiveRate = $effectiveRate / 100;
    	return $effectiveRate;
    }
    
    public function getCompounding($accumulation){
    	switch ($accumulation) {
    		case 'Daily':
    			$compounding = 365;
    			break;

			case 'Weekly':
    			$compounding = 52;
    			break;

    		case 'Biweekly':
    			$compounding = 26;
    			break;

    		case 'Monthly':
    			$compounding = 12;
    			break;

    		case 'Bimonthly':
    			$compounding = 6;
    			break;

    		case 'Quarterly':
    			$compounding = 4;
    			break;

    		case 'Semi-annually':
    			$compounding = 2;
    			break;

    		case 'Annually':
    			$compounding = 1;
    			break;

    		default:
    			$compounding = 1;
    			break;
    	}

    	return $compounding;
    }
}