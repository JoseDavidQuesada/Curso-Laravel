<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    /**
     * A very basic test that doesn't require Laravel.
     *
     * @return void
     */
    public function testBasicPHPFunctionality()
    {
        $this->assertTrue(true);
        $this->assertEquals(4, 2 + 2);
        $this->assertIsString('Hello World');
        $this->assertIsArray([1, 2, 3]);
    }

    /**
     * Test basic string operations.
     *
     * @return void
     */
    public function testStringOperations()
    {
        $string = 'Laravel Testing';
        $this->assertStringContainsString('Laravel', $string);
        $this->assertEquals(15, strlen($string));
        $this->assertEquals('LARAVEL TESTING', strtoupper($string));
    }

    /**
     * Test basic array operations.
     *
     * @return void
     */
    public function testArrayOperations()
    {
        $array = [1, 2, 3, 4, 5];
        $this->assertCount(5, $array);
        $this->assertContains(3, $array);
        $this->assertEquals(15, array_sum($array));
    }
}