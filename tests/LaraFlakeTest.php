<?php

namespace Hafael\LaraFlake\Tests;

use Hafael\LaraFlake\LaraFlake;
use Orchestra\Testbench\TestCase;

class LaraFlakeTest extends TestCase
{

    public function testSomethingIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testIdGenerator()
    {
        $id = LaraFlake::generateID();

        $this->assertNotEmpty($id);
    }
}
