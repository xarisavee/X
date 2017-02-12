<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSpousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_spouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id', 11);
            $table->string('user_spouse_name');
            $table->string('user_spouse_occupation');
            $table->string('user_spouse_contact');
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
        Schema::dropIfExists('user_spouses');
    }
}
