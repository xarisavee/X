<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->role_id 		= "1";
        $role->role_desc	= "Superadmin";
        $role->save();

        $role = new Role;
        $role->role_id 		= "2";
        $role->role_desc	= "Loan Officer";
        $role->save();

        $role = new Role;
        $role->role_id 		= "3";
        $role->role_desc	= "Bookkeeper";
        $role->save();

        $role = new Role;
        $role->role_id 		= "4";
        $role->role_desc	= "Credit Officer";
        $role->save();

        $role = new Role;
        $role->role_id 		= "5";
        $role->role_desc	= "Audit Officer";
        $role->save();

        $role = new Role;
        $role->role_id 		= "6";
        $role->role_desc	= "Member";
        $role->save();
    }
}
