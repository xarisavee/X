<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id');
            $table->string('loan_user_id');
            $table->string('loan_id');
            $table->string('loan_payment_id');
            $table->date('loan_payment_date');
            $table->string('loan_payment_amount');
            $table->string('loan_payment_totalpaid');
            $table->string('added_by');
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
        Schema::dropIfExists('loan_payments');
    }
}
