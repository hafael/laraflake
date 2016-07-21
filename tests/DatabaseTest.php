<?php

namespace Hafael\LaraFlake\Tests;


use Orchestra\Testbench\TestCase;

class DatabaseTest extends TestCase
{
    public function testMysqlDatabase()
    {
        $db_name = \DB::getName();

        $this->assertEquals('mysql', $db_name);
    }
}