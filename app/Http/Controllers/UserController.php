<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUserRegister(){
        return view('frontend.user_register');
    }

    public function postUserRegister(Request $request){
        $user = User::where('email', $request['email'])->first();
        if($user){
            return redirect()->back()->with('flash_message_error', 'Địa chỉ email đã được sử dụng.');
        }
        return $request->all();
    }

    public function getUserLogin(){
        return view('frontend.user_login');
    }

    public function postUserLogin(Request $request){
        return $request->all();
    }
}
