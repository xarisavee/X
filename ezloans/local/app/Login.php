<?php

namespace App;
use Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Login extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

	protected $primaryKey = 'user_id';

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_users', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles, $domain){
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role, $domain)) {
                     echo $role."    ".$domain;
                    // return true;
                }
            }
        } else {
            if ($this->hasRole($roles, $domain)) {
                 // echo $role."    ".$domain;
                // return true;
            }
        }
        // return false;
    }
    
    public function hasRole($role, $domain){
        if ($this->roles()->where('roles.role_desc', $role)->first()) {
            echo $role;
            return true;
        }
        return false;
    }
}
