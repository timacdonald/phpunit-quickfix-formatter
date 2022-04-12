<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class AnotherTest extends TestCase
{
    public function test_it_works(): void
    {
        $this->assertTrue(false, 'ANOTHER TEST HERE');
    }

    public function test_it_works_again(): void
    {
        $this->assertContains(['a' => 'b'], ['d' => 123]);
    }
}
