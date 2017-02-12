<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{

    use \Illuminate\Auth\Authenticatable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'user_id';    
    
    protected $fillable = [
        'user_fname', 'user_mname', 'user_lname', 'user_ptitle', 'user_sex', 'user_civilstatus', 'user_nationality', 'user_bday', 'user_bplace', 'user_address', 'user_mobile', 'user_landline'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function login(){
        return $this->hasOne('App\Login', 'user_id');
    }

    public function cooperative(){
        return $this->belongsTo('App\Cooperative', 'coop_id');
    }

    public function loans(){
        return $this->hasMany('App\LoanUser', 'user_id');
    }

    public function comaker(){
        return $this->hasMany('App\LoanCoMaker', 'user_id', 'loan_id');
    }

    // public function roles(){
    //     return $this->hasOne('App\RoleUser', 'role_users', 'user_id', 'role_id');
    // }
}
