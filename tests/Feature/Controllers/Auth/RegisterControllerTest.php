<?php

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    /**
     * 測試一般用戶註冊
     *
     * @return void
     */
    public function testRegisterWithNormalUser()
    {
        $credential = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'secret@123',
            'password_confirmation' => 'secret@123',
        ];

        $response = $this->json('POST', '/v1/register', $credential)
                        ->assertStatus(200)
                        ->assertJsonStructure([
                            'access_token',
                            'token_type',
                            'expires_in',
                            'user' => ['id', 'email']
                        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'test',
        ]);
    }

    /**
     * 測試一般用戶註冊，當該email已被註冊過
     *
     * @return void
     */
    public function testRegisterWithNormalUserWhenEmailWasTaken()
    {
        $user = factory(User::class)->create();

        $credential = [
            'name' => 'test',
            'email' => $user->email,
            'password' => 'secret@123',
            'password_confirmation' => 'secret@123',
        ];

        $response = $this->json('POST', '/v1/register', $credential)
                        ->assertStatus(422)
                        ->assertJson([
                            'message' => 'Register Error',
                            'errors' => [
                                [
                                    'code' => 'E0101',
                                    'description' => 'Email was taken.',
                                ]
                            ]
                        ]);
    }

    /**
     * 測試一般用戶註冊，當密碼不符規則
     *
     * @return void
     */
    public function testInvalidPasswordLength()
    {
        $credential = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->json('POST', '/v1/register', $credential)
                        ->assertStatus(422)
                        ->assertJson([
                            'message' => 'Validation Error',
                            'errors' => [
                                [
                                    'field' => 'password',
                                    'description' => 'The password must be at least 8 characters.',
                                ]
                            ]
                        ]);
    }
}
