<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Exception;

use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class PropertyNotFoundExceptionTest extends TestCase
{
    public function testCreate()
    {
        $ex = new PropertyNotFoundException('TestClass', 'something', 0, new \Exception());

        $this->assertEquals("Class \"TestClass\" doesn't have property \"something\"", $ex->getMessage());
        $this->assertEquals("TestClass", $ex->getClassName());
        $this->assertEquals("something", $ex->getPropertyName());
    }
}