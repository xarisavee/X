<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
 //    public function users(){
	// 	return $this->belongsToMany('App\User','role_users', 'role_id', 'user_id');
	// }

	public function roleusers(){
		return $this->hasMany('App\RoleUser', 'role_users', 'coop_id', 'user_id');
	}
}
