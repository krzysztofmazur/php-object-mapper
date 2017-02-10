<?php

namespace KrzysztofMazur\ObjectMapper\Util;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;

class Reflection
{
    private function __construct()
    {
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @param bool   $setAccessible
     * @return \ReflectionProperty
     * @throws PropertyNotFoundException
     */
    public static function getProperty($className, $propertyName, $setAccessible = false)
    {
        $reflectionClass = new \ReflectionClass($className);
        if (!$reflectionClass->hasProperty($propertyName)) {
            throw new PropertyNotFoundException($className, $propertyName);
        }
        $property = $reflectionClass->getProperty($propertyName);
        if ($setAccessible) {
            $property->setAccessible(true);
        }

        return $property;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param bool   $setAccessible
     * @return \ReflectionMethod
     * @throws MethodNotFoundException
     */
    public static function getMethod($className, $methodName, $setAccessible = false)
    {
        $reflectionClass = new \ReflectionClass($className);
        if (!$reflectionClass->hasMethod($methodName)) {
            throw new MethodNotFoundException($className, $methodName);
        }
        $method = $reflectionClass->getMethod($methodName);
        if ($setAccessible) {
            $method->setAccessible(true);
        }

        return $method;
    }
}
