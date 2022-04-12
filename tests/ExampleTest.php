<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_it_works(): void
    {
        $this->assertTrue(false, 'Hey Tim, this test failed');
    }

    public function test_it_works_again(): void
    {
        $this->assertTrue(false, 'Can you not write any good code? Shesh Tim.');
    }
}
