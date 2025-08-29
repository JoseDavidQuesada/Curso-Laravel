<?php

namespace Tests\Unit;

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
        $this->assertTrue(true);
    }

    /**
     * Test that the application can perform basic operations.
     *
     * @return void
     */
    public function testBasicApplicationFunctionality()
    {
        // Test basic PHP functionality
        $this->assertEquals(4, 2 + 2);
        $this->assertIsString('Hello World');
        $this->assertIsArray([1, 2, 3]);
        
        // Test that we can create basic objects
        $collection = collect([1, 2, 3]);
        $this->assertCount(3, $collection);
    }
}
