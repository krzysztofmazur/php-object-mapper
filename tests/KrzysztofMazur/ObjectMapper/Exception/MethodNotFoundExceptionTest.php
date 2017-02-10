<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Exception;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use PHPUnit\Framework\TestCase;

class MethodNotFoundExceptionTest extends TestCase
{
    public function testCreate()
    {
        $ex = new MethodNotFoundException('TestClass', 'getSomething', 0, new \Exception());

        $this->assertEquals("Class \"TestClass\" doesn't have method \"getSomething\"", $ex->getMessage());
        $this->assertEquals("TestClass", $ex->getClassName());
        $this->assertEquals("getSomething", $ex->getMethodName());
    }
}
