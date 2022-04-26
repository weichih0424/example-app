<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUsersModel;
use App\Services\SignUp_Store_Service;
use Exception;

class SignUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    # 註冊需要輸入帳號跟密碼還有名稱
    protected $guarded = [];
    protected $signature = 'sign-up {account} {password} {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = '註冊用的指令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SignUp_Store_Service $SignUp_Store_Service)
    {
        $account = $this->argument('account');
        $password = $this->argument('password');
        $username = $this->argument('username');
        try{
            if($SignUp_Store_Service->signUp($account, $password, $username)){
                $this->line("註冊成功");
            }
        } catch (Exception $e){
            $this->error($e->getMessage());
        }
        
        return 0;
        // $validator = Validator::make(['password' => $password], [
        //     'password' => 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
        // ]);

        // // if ($validator->fails()) {
        // //     $this->error("密碼需要6位數以上，並且至少包含大寫字母、小寫字母、數字、符號各一");
        // //     return 1;
        // // }
        // $user = AdminUsersModel::where('account', $account)->first();
        // // $user = DB::table('admin_users_models')->where('account', $account)->first();
        // if($user !== null){
        //     $this->error("帳號重複註冊");
        //     return 1;
        // }
        // if($user === null){
        //     // insert data
        //     // DB::table('admin_users_models')->insert([
        //     //     'account' => $account,
        //     //     'password' => Hash::make($password),
        //     //     'name' => $username,
        //     // ]);
        //     AdminUsersModel::insert([
        //         'account' => $account,
        //         'password' => Hash::make($password),
        //         'name' => $username
        //     ]);
        // }
        // $this->line("帳號註冊成功");
        // return 0;
    }
}
