<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * 測試不存在的Uri
     *
     * @return void
     */
    public function testUriIsNotExisted()
    {
        $response = $this->get('/v1/testuri');

        $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Not Found Error',
                    'errors' => [
                        [
                            'code' => 'E9002',
                            'description' => 'HTTP not found!'
                        ]
                    ]
                ]);
    }
}
