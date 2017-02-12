<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id')->unique();
            $table->string('coop_domain');
            $table->string('coop_name');
            $table->string('coop_address');
            $table->string('coop_contact');
            $table->string('coop_email')->unique();
            $table->date('coop_foundation_date');
            $table->string('coop_authsharecapital');
            $table->string('coop_sharecapital');
            $table->rememberToken();
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
        Schema::dropIfExists('cooperatives');
    }
}
