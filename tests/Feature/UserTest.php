<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_get_list(): void
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(500);
    }
}
