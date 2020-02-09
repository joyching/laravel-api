<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    /**
     * 測試一般使用者登入
     *
     * @return void
     */
    public function testNormalUserCanLogin()
    {
        $user = factory(User::class)->create();
        $credential = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->json('POST', '/v1/login', $credential)
             ->assertStatus(200)
             ->assertJsonStructure([
                 'access_token',
                 'token_type',
                 'expires_in',
                 'user' => ['id', 'email'],
             ]);
    }

    /**
     * 測試一般使用者登入，當帳號/密碼輸入錯誤
     *
     * @return void
     */
    public function testNormalUserCannotLoginWithInvalidAuth()
    {
        $credential = [
            'email' => 'test@example.com',
            'password' => 'secret123',
        ];

        $this->json('POST', '/v1/login', $credential)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Authorization Error',
                'errors' => [
                    [
                        'code' => 'E0102',
                        'description' => 'Invalid Credential.',
                    ]
                ]
            ]);
    }
}
