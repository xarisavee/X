<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('loan_id');
            $table->string('loan_season_start');
            $table->string('loan_season_end');
            $table->boolean('loan_season_status');
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
        Schema::dropIfExists('loan_seasons');
    }
}
