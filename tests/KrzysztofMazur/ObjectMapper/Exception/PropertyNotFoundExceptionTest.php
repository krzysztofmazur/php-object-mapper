<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Exception;

use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class PropertyNotFoundExceptionTest extends TestCase
{
    public function testCreate()
    {
        $ex = new PropertyNotFoundException('TestClass', 'something', 0, new \Exception());

        self::assertEquals("Class \"TestClass\" doesn't have property \"something\"", $ex->getMessage());
        self::assertEquals("TestClass", $ex->getClassName());
        self::assertEquals("something", $ex->getPropertyName());
    }
}