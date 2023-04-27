<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function login(Request $req){
        $user = DB::table('admins')->where(['email'=>$req->email])->first();
        if($user == null){
            return redirect('/admin');
        }
        else{
            if($user->password == $req->password){
                $req->session()->put('user', $user);
                return redirect('/dashboard');   
            }
            else{
                return redirect('/admin');
            }
        }
    }
}
