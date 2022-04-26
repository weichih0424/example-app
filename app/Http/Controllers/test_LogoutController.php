<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class test_LogoutController extends Controller{
    public function __invoke(Request $request)
    {
        $request->session()->flush();
        return view('test_welcome');
    }
}
