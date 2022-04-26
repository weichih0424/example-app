<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AdminTest extends TestCase
{
    // use WithoutMiddleware;
    use DatabaseTransactions;
    /**
     * 測試註冊頁面
     */
    public function Admin()
    {
        $this->withoutMiddleware();
        $response = $this->get('/admin/admin');

        $response->assertOk();
    }
    /**
     * 測試註冊表單
     */
    public function Post_Admin()
    {
        $this->withoutMiddleware();
        $response = $this->post('/admin/admin', [
            'acc' => 'test',
            'pw' => 'password',
            'pw2' => 'password'
        ]);

        $response->assertRedirect('/admin/admin');
    }
    /**
     * 測試登入頁面
     */
    public function Login()
    {
        $this->withoutMiddleware();
        $response = $this->get('/login');

        $response->assertSuccessful();
    }
    /**
     * 測試提交登入表單
     */
    public function Post_Login()
    {
        $this->withoutMiddleware();
        $Admin = Admin::where('acc', 'test')->first();
        $response = $this->post('/login', [
            'acc' => $Admin->acc,
            'pw' => 'password',
        ]);

        $response->assertRedirect('/admin');
    }
    /**
     * 測試 /image 圖片上傳
     */
    public function Image()
    {
        $this->withoutMiddleware();
        Storage::fake('photos');  // 偽造目錄
        $photo = UploadedFile::fake()->image('picture.jpg');  // 偽造上傳圖片

        $this->post('/admin/image', [
            'img' => $photo,
            // 'style'=>'width:100px;header:68px'
        ]);

        Storage::disk('photos')->assertMissing('picture.jpg');   // 斷言文件是否上傳成功
                                                                 // 確認文件不存在
    }
    // /**
    //  * 测试未认证状态下访问 /home 路由
    //  */
    // public function test_Home_Without_Authenticated()
    // {
    //     $response = $this->get('/admin');

    //     $response->assertRedirect('/login');  // 用户未认证则跳转到登录页
    //     $this->assertGuest();  // 断言用户未认证
    //     // 断言给定认证凭证是否匹配
    //     $this->assertCredentials([
    //         'acc' => '123',
    //         'pw' => '123'
    //     ]);
    // }
    /**
     * 测试认证状态下访问 /home 路由
     */
    public function Home_With_Authenticated()
    {
        $user = Admin::where('acc', 'test')->first();
        $this->actingAs($user)->get('/admin');
        $this->assertAuthenticated('web')
            ->assertAuthenticatedAs($user);  // 断言用户认证且以 $user 身份认证
    }
}
