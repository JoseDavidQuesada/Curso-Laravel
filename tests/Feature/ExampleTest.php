<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that login page is accessible.
     *
     * @return void
     */
    public function testLoginPageIsAccessible()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
    }

    /**
     * Test that register page is accessible.
     *
     * @return void
     */
    public function testRegisterPageIsAccessible()
    {
        $response = $this->get('/register');
        
        $response->assertStatus(200);
    }
}
