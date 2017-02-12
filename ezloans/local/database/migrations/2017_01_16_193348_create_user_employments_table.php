<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_employments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id', 11);
            $table->string('user_emp_sector', 50);
            $table->string('user_emp_occupation', 50);
            $table->string('user_emp_name', 150);
            $table->string('user_emp_address', 150);
            $table->string('user_emp_contact', 15);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_employments');
    }
}
