<?php

use Illuminate\Database\Seeder;
use App\InterestMethod;

class InterestMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interestmethod = new InterestMethod;
        $interestmethod->int_method_id = "1";
        $interestmethod->int_method_name = "Flat Rate";
        $interestmethod->save();

        $interestmethod = new InterestMethod;
        $interestmethod->int_method_id = "2";
        $interestmethod->int_method_name = "Reducing Balance - Equal Amortization";
        $interestmethod->save();

        $interestmethod = new InterestMethod;
        $interestmethod->int_method_id = "3";
        $interestmethod->int_method_name = "Reducing Balance - Equal Principal";
        $interestmethod->save();

        $interestmethod = new InterestMethod;
        $interestmethod->int_method_id = "4";
        $interestmethod->int_method_name = "Interest Only";
        $interestmethod->save();
    }
}
