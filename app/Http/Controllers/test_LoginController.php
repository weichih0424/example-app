<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\AdminUsersModel;

class test_LoginController extends Controller
{
    // public function login(Request $request){
    //     $account = $request->input('account');
    //     $password = $request->input('password');

    //     $user = DB::table('admin_users_models')->where('account', '=', $account)->first();
    //     if(Hash::check($password, $user->password)){
    //         return "你好，我的帳號是".$request->input('account');
    //     }
    //     return Redirect::back()->withErrors(['帳號或密碼錯誤']);
    // }

    public function loginWithORM(Request $request){
        $account = $request->input('account');
        $password = $request->input('password');
        $user = AdminUsersModel::query()
        ->where('account', $account)
        ->first();
        if($user !== NULL && Hash::check($password, $user->password)){
            session(['user' => $user]);
            // return "你好，我的帳號是".$user->account;
            return view('test_welcome');
        }
        return Redirect::back()->withErrors(['帳號或密碼錯誤']);
    }

    // public function logout(Request $request)
    // {
    //     $request->session()->flush();
    //     return view('test_welcome');
    // }
}