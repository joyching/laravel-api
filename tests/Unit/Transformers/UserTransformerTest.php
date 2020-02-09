<?php

namespace Tests\Unit\Transformers;

use Tests\TestCase;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new UserTransformer;

        $user = factory(User::class)->make();

        $expected = [
            'id' => $user->id,
            'name' => $user->name,
        ];

        $actual = $transformer->transform($user);

        $this->assertEquals($expected, $actual);
    }
}
