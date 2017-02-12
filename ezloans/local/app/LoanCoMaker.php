<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanCoMaker extends Model
{
    public $timestamps = false;

    public function comaker(){
    	return $this->hasMany('App\LoanCoMaker', 'loan_id', 'user_id');
    }
}
