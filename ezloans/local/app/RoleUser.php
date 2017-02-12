<?php

namespace App;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class RoleUser extends Model
{
	// protected $primaryKey = 'roleuser_id';

    // public function roles(){
    // 	return $this->belongsTo('App\Role', 'role_id');
    // }

    public function roles(){
        return $this->belongsTo('App\Role', 'role_users', 'role_id', 'user_id');
    }

    public function users(){
    	return $this->belongsToMany('App\User', 'role_users', 'user_id', 'role_id');
    }

    public function cooperative(){
        return $this->belongsTo('App\cooperative', 'cooperatives', 'role_id', 'coop_id');
    }

    
}
