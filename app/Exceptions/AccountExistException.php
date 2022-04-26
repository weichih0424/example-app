<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AccountExistException extends Exception
{
    public $error = "帳號重複註冊";

    // public function __construct(Request $request)
    // {
    //     dd(response()->json(['error' => $this->error,]));
    //     // // dd('123');
    //     // // dd($this->error );
    //     // return response()->json([
    //     //     'error' => $this->error,
    //     //     // 'error' => '帳號錯誤',
    //     // ]);
    // }
    public function render(Request $request)
    {
        return response()->json([
            'error' => $this->error,
        ]);
    }

}
