<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Product;
use App\Category;


class AdminController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('admin.admin_login');
    }

    public function postLogin(Request $request){
        $data = $request->input();
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'admin'=>'1'])){
            return redirect()->route('dashboard');
        }else{
            return redirect('/system-cpanel')->with('flash_message_error', 'Email hoặc mật khẩu không đúng!');
        }
    }

    public function dashboard(){
        $total_products = Product::all()->count();
        $total_categories = Category::all()->count();
        return view('admin.dashboard')->withTotalProducts($total_products)->withTotalCategories($total_categories);
    }

    public function settings(){
        return view('admin.settings');
    }

    public function checkPass(Request $request){
        $data = $request->all();
        $current_pwd = $data['current_pwd'];
        $check_pass = User::where(['email' => Auth::user()->email])->first();
        if(Hash::check($current_pwd, $check_pass->password)){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $current_pwd = $data['current_pwd'];
            $check_pass = User::where(['email' => Auth::user()->email])->first();
            if(Hash::check($current_pwd, $check_pass->password)){
                $password = bcrypt($data['new_pwd']);
                User::where('email', Auth::user()->email)->update(['password'=>$password]);
                return redirect('/system-cpanel/settings')->with('flash_message_success', 'Đổi mật khẩu thành công!');
            }else{
                return redirect('/system-cpanel/settings')->with('flash_message_error', 'Mật khẩu hiện tại không đúng!');
            }
        }
    }

    public function logout(){
        Auth::logout();

        return redirect('/system-cpanel')->with('flash_message_success', 'Đăng xuất thành công!'); 
    }
}
