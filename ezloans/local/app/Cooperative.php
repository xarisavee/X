<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cooperative extends Model
{
    public function user(){
    	return $this->hasMany('App\User', 'coop_id');
    }

    public function roles(){
    	return $this->hasMany('App\RoleUser', 'role_users', 'coop_id', 'role_id');
    }
}
