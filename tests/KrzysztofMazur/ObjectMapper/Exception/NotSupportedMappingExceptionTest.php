<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Exception;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;
use PHPUnit\Framework\TestCase;

class NotSupportedMappingExceptionTest extends TestCase
{
    public function testCreateWithOneClass()
    {
        $ex = new NotSupportedMappingException("TestClass", null, 0, new \Exception());

        $this->assertEquals("Class \"TestClass\" is not supported", $ex->getMessage());
    }

    public function testCreateWithTwoClasses()
    {
        $ex = new NotSupportedMappingException("TestClass", "TestClass2", 0, new \Exception());

        $this->assertEquals("Mapping from \"TestClass\" to \"TestClass2\" is not supported", $ex->getMessage());
    }
}
