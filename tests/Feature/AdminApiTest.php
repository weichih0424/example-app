<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_store()
    {
        $this->postJson('/api/admin', ['acc' => 'qwe123', 'pw' => '!Aqwe123'])
            ->assertStatus(201);
    }
    // public function test_admin_update()
    // {

    // }
}
