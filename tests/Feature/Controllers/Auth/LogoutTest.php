<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends PassportTestCase
{
    use RefreshDatabase;

    /**
     * 測試登出
     *
     * @return void
     */
    public function testLogout()
    {
        $response = $this->json('GET', '/v1/logout')
                        ->assertStatus(200)
                        ->assertJsonStructure(['logout_time']);

        $this->assertDatabaseHas('users', ['signature' => '']);
    }
}
