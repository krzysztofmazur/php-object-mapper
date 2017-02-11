<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Exception;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use PHPUnit\Framework\TestCase;

class MethodNotFoundExceptionTest extends TestCase
{
    public function testCreate()
    {
        $ex = new MethodNotFoundException('TestClass', 'getSomething', 0, new \Exception());

        self::assertEquals("Class \"TestClass\" doesn't have method \"getSomething\"", $ex->getMessage());
        self::assertEquals("TestClass", $ex->getClassName());
        self::assertEquals("getSomething", $ex->getMethodName());
    }
}
