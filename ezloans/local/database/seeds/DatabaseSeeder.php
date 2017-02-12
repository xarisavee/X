<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(RoleSeeder::class);
        $this->call(LoanRequestSeeder::class);
        $this->call(InterestMethodSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
