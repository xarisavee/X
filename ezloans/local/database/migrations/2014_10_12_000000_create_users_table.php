<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coop_id');
            $table->string('user_id', 11)->nullable();
            $table->string('user_fname', 30);
            $table->string('user_mname', 30);
            $table->string('user_lname', 30);
            $table->string('user_sex', 6)->nullable();
            $table->string('user_civilstatus', 30)->nullable();
            $table->string('user_nationality', 50)->nullable();
            $table->string('user_email')->unique();
            $table->date('user_bday')->nullable();
            $table->string('user_zip', 10)->nullable();
            $table->string('user_bplace', 100)->nullable();
            $table->string('user_address', 200)->nullable();
            $table->string('user_mobile', 11)->nullable();
            $table->string('user_landline', 11)->nullable();
            $table->string('user_religion', 30)->nullable();
            $table->string('user_educAttain', 30)->nullable();
            $table->string('user_school', 150)->nullable();
            $table->string('user_schooladdress', 150)->nullable();
            $table->string('user_photo', 250)->nullable();
            $table->datetime('user_created');
            $table->string('user_addedby', 11)->nullable();
            $table->datetime('user_expire')->nullable();
            $table->boolean('user_status',7);
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
        Schema::drop('users');
    }
}
