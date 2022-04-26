<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class RegisterTest extends DuskTestCase
{
    use WithoutMiddleware;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_login()
    {
        // $this->browse(function (Browser $browser) {
        //     $browser->visit('/admin/admin')               // 访问首页
        //             ->clickLink('Register')   // 点击注册按钮
        //             ->assertSee('Register')   // 断言注册页面包含Register文本
        //             // 通过下面这些值填充注册表单
        //             ->value('$acc', 'test01')
        //             ->value('$pw', '!Atest123456')
        //             ->value('$pw2', '!Atest123456')
        //             ->click('button[type="submit"]')    // 点击注册按钮
        //             ->assertPathIs('/home')  // 注册成功后跳转到 /home 页面
        //             ->assertSee("You are logged in!");  // 登录成功后提示文本
        // });
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')               // 訪問登入頁面
                    // 通過下面這些值填入登入表單
                    ->value('#acc', '123')
                    ->value('#pw', '123')
                    // ->press('登入')
                    ->click('input[type="submit"]')
                    ->assertPathIs('/admin/title');  // 登入成功後跳轉到 /admin/title 畫面
        });
    }
}
