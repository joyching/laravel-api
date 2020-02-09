<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;

class PassportTestCase extends TestCase
{
    protected $authenticateUser;

    public function setUp()
    {
        parent::setUp();

        $this->authenticateUser = factory(User::class)->create();

        Passport::actingAs($this->authenticateUser);
    }
}
