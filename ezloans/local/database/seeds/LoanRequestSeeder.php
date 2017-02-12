<?php

use Illuminate\Database\Seeder;
use App\LoanRequest;

class LoanRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loanrequest = new LoanRequest;

        $loanrequest->loan_request_id = "1";
        $loanrequest->loan_request_desc = "Pending";
        $loanrequest->save();

        $loanrequest = new LoanRequest;
        $loanrequest->loan_request_id = "2";
        $loanrequest->loan_request_desc = "Approved";
        $loanrequest->save();

        $loanrequest = new LoanRequest;
        $loanrequest->loan_request_id = "3";
        $loanrequest->loan_request_desc = "Rejected";
        $loanrequest->save();
    }
}
