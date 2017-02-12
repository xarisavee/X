<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id');
            $table->string('loan_user_id');
            $table->string('loan_id');
            $table->string('loan_user_interest_method');
            $table->string('loan_user_disbursement');
            $table->float('loan_user_amount');
            $table->float('loan_user_amortization')->nullable();
            $table->string('loan_user_terms');
            $table->string('loan_user_duration');
            $table->string('loan_user_rate');
            $table->string('loan_user_accumulation');
            $table->string('loan_user_retention');
            $table->string('loan_user_processing');
            $table->string('loan_user_repayment');
            $table->date('loan_user_termstart');
            $table->date('loan_user_termend');
            $table->string('user_addedby');
            $table->string('loan_user_request');
            $table->string('loan_user_comment')->nullable();
            $table->boolean('loan_user_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_users');
    }
}
