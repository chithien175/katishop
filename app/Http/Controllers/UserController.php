<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserRegister(){
        return view('frontend.user_register');
    }

    public function postUserRegister(Request $request){
        return $request->all();
    }

    public function getUserLogin(){
        return view('frontend.user_login');
    }

    public function postUserLogin(Request $request){
        return $request->all();
    }
}
