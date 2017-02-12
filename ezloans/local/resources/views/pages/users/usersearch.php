<?php

namespace App\Http\Controllers;
use App\Login;
use App\User;
use App\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Hash;
use DB;
use Redirect;
use AuthenticatesAndRegistersUsers;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    $key=$_GET['key'];

    $search = DB::table('users')
            ->select(array('user_id', 'user_fname', 'user_mname', 'user_lname'))
            ->where('user_id', 'LIKE', '%'.$key.'%')
            ->where('user_fname', 'LIKE', '%'.$key.'%')
            ->where('user_lname', 'LIKE', '%'.$key.'%')
            ->get()->toArray();

     $search = json_decode(json_encode($search), True);
    
}