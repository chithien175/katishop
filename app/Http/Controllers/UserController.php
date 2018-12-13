<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function getUserRegister(){
        return view('frontend.user_register');
    }

    public function postUserRegister(Request $request){
        if(!isset($request['cb_confirm'])){
            return redirect()->back()->with('flash_message_error', 'Vui lòng đồng ý điều kiện sử dụng và chính sách!');
        }else{
            $user = new User;
            $user->name = $request['fullname'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
            if(Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']])){
                return redirect()->route('get.cart');
            }
        }
    }

    public function getUserLogin(){
        return view('frontend.user_login');
    }

    public function postUserLogin(Request $request){
        if(Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']])){
            return redirect()->route('get.cart');
        }else{
            return redirect()->back()->with('flash_message_error', 'Đăng nhập không thành công! Email hoặc mật khẩu không đúng!');
        }
    }

    public function getCheckEmail(Request $request){
        $check_user = User::where('email', $request['email'])->first();
        if($check_user){
            echo "false";
        }else{
            echo "true"; die;
        }
    }

    public function getUserLogout(){
        Auth::logout();
        return redirect()->route('homepage');
    }

    public function getUserAccount(){
        return view('frontend.user_account');
    }
}
