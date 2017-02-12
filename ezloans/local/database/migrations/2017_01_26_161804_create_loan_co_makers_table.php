<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanCoMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_co_makers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id');
            $table->string('loan_user_id');
            $table->string('comaker_id');
            $table->string('comaker_name',150);
            $table->string('comaker_address',200);
            $table->string('comaker_sex');
            $table->string('comaker_contact');
            $table->string('comaker_relationship', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_co_makers');
    }
}
