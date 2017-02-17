<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Util;

use KrzysztofMazur\ObjectMapper\Util\Reflection;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ReflectionTest extends TestCase
{
    public function testGetReflectionClassSuccess()
    {
        $reflectionClass = Reflection::getReflectionClass(SimpleObject::class);

        self::assertInstanceOf(\ReflectionClass::class, $reflectionClass);
        self::assertEquals(SimpleObject::class, $reflectionClass->getName());
    }

    /**
     * @expectedException \ReflectionException
     */
    public function testGetReflectionClassFail()
    {
        Reflection::getReflectionClass("FakeClassNameXYZ");
    }

    public function testGetProperty()
    {
        $property = Reflection::getProperty(SimpleObject::class, "property1");

        self::assertInstanceOf(\ReflectionProperty::class, $property);
        self::assertEquals("property1", $property->getName());
    }

    public function testGetMethod()
    {
        $method = Reflection::getMethod(SimpleObject::class, "getProperty1");

        self::assertInstanceOf(\ReflectionMethod::class, $method);
        self::assertEquals("getProperty1", $method->getName());
    }

    public function testGetPropertyNames()
    {
        $properties = Reflection::getPropertyNames(SimpleObject::class);

        self::assertCount(1, $properties);
        self::assertContains('property1', $properties);
    }

    public function testGetMethodNames()
    {
        $methods = Reflection::getMethodNames(SimpleObject::class);

        self::assertCount(2, $methods);
        self::assertContains('getProperty1', $methods);
        self::assertContains('setProperty1', $methods);
    }
}
