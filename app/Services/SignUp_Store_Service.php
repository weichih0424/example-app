<?php
namespace App\Services;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\PasswordInvalidException;
use App\Exceptions\AccountExistException;
use App\Models\AdminUsersModel;
use Illuminate\Support\Facades\Hash;

class SignUp_Store_Service
{
    const PASSWORD_REGEX = "/^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/";

    public function signUp(
        string $account,
        string $password,
        string $username
        )
    {
        $validator = Validator::make(['password' => $password], [
            'password' => 'regex:' . SignUp_Store_Service::PASSWORD_REGEX
        ]);
        if ($validator->fails()) {
            throw new PasswordInvalidException();
        }
        $user = AdminUsersModel::where('account', $account)->first();
        if($user !== null){
            throw new AccountExistException();
        }
        AdminUsersModel::insert([
            'account' => $account,
            'password' => Hash::make($password),
            'name' => $username
        ]);
        return true;
    }

}