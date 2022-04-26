<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;          //清空資料庫
use Illuminate\Foundation\Testing\DatabaseTransactions;     //回復到測試前的資料庫
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\SignUp_Store_Service;
use App\Models\AdminUsersModel;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use PDOException;

class UserTest extends TestCase
{
    //-------------------------------刪除成功測試-------------------------------
    public function DestorySuccess()
    {
        //arrange
        $id = 100;
        $account = "a890424";
        $password = "@Aeric890424";
        $username = "eric";
        AdminUsersModel::insert([
            'id' => $id,
            'account' => $account,
            'password' => Hash::make($password),
            'name' => $username
        ]);
        // act&assert
        $this->deleteJson("/api/test_user/$id")
        ->assertStatus(200)
        ->assertJson([
            'success' => 'true'
        ]);
    }

    //-------------------------------刪除失敗測試-------------------------------
    public function destoryFailed()
    {
        //arrange
        $id = 10000;
        // act&assert
        $this->deleteJson("/api/test_user/$id")
        ->assertStatus(200)
        ->assertJson([
            'success' => 'false'
        ]);
    }

    //-----------------------------帳號新增成功測試-------------------------------
    public function storeSuccess()
    {
        //arrange
        $id = 1000;
        $account = "jimchien";
        $password = "123Acb_";
        $username = "Jim";

        // act&assert
        $this->postJson("/api/test_user", [
            'id'=>$id,
            'account'=>$account,
            'password'=>$password,
            'username'=>$username
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => 'true'
        ]);
    }

    //---------------------------帳號重複註冊測試----------------------------
    public function storeAccountRepeat()
    {
        //arrange
        $id = 1000;
        $account = "jimchien";
        $password = "123Acb_";
        $username = "Jim";
        // AdminUsersModel::insert([
        //     'id' => $id,
        //     'account' => $account,
        //     'password' => $password,
        //     'name' => $username
        // ]);

        // act&assert
        $this->postJson("/api/test_user", [
            'id'=>$id,
            'account'=>$account,
            'password'=>$password,
            'username'=>$username
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => 'false',
            'error'=> ''
        ]);
    }
    //----------------------------不合格的密碼測試----------------------------
    public function invalidPasswordProvider()
    {
        // 密碼長度不足6位
        yield ["123"];
        // 密碼不含大寫字母
        yield ["123abc_"];
        // 密碼不含小寫字母
        yield ["123ABC_"];
        // 密碼不含數字
        yield ["ABCabc_"];
        // 密碼不含特殊符號
        yield ["ABCabcd"];
    }
    /**
     * @test
     * @dataProvider invalidPasswordProvider
     */
    public function storeAccountPasseordInvalid(string $password)
    {
        //arrange
        $id = 10;
        $account = "jimchien";
        $username = "Jim";

        // act&assert
        $this->postJson("/api/test_user", [
            'id'=>$id,
            'account'=>$account,
            'password'=>$password,
            'username'=>$username
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => 'false',
            // 'error'=> '密碼需要6位數以上，並且至少包含大寫字母、小寫字母、數字、符號各一'
        ]);
    }

    public function test_storeGetPDOException()
    {
        //arrange
        $this->mock(AdminUsersModel::class, function (MockInterface $mock) {
            $mock->shouldReceive('signUp')
                ->andThrow(new PDOException());
        });
        $id = 10;
        $account = "JimChien";
        $username = "Jim";
        $password = "123Acb_";

        // act&assert
        $this->postJson("/api/test_user", [
            'id'=>$id,
            'account'=>$account,
            'password'=>$password,
            'username'=>$username
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => 'false',
            // 'error'=> 'DB error'
        ]);
    }
}
