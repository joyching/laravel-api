<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends PassportTestCase
{
    use RefreshDatabase;

    /**
     * 可以取得使用者資訊
     *
     * @return void
     */
    public function testCanGetUser()
    {
        $expected = [
            'id' => $this->authenticateUser->id,
            'name' => $this->authenticateUser->name,
        ];

        $this->get('/v1/me')->assertJson($expected);
    }

    /**
     * 可以更新使用者資訊
     *
     * @return void
     */
    public function testCanUpdateUser()
    {
        $expected = [
            'id' => $this->authenticateUser->id,
            'name' => 'Michael Jeffrey Jordan',
        ];

        $this->put('/v1/me', [
            'name' => 'Michael Jeffrey Jordan',
        ])->assertJson($expected);
    }
}
