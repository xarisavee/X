<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id');
            $table->string('loan_user_id');
            $table->string('loan_schedule_id'); //month (schedule) number
            $table->date('loan_schedule_date'); // schedule ng payment can be adjusted
            $table->string('loan_schedule_amount');
            $table->string('loan_schedule_fee');
            $table->string('loan_schedule_penalty'); //payment for that schedule
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
        Schema::dropIfExists('loan_schedules');
    }
}
