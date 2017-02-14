<?php

namespace KrzysztofMazur\ObjectMapper\Util;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;

class Reflection
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param string $className
     * @return \ReflectionClass
     */
    public static function getReflectionClass($className)
    {
        return new \ReflectionClass($className);
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
        $reflectionClass = self::getReflectionClass($className);
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
        $reflectionClass = self::getReflectionClass($className);
        if (!$reflectionClass->hasMethod($methodName)) {
            throw new MethodNotFoundException($className, $methodName);
        }
        $method = $reflectionClass->getMethod($methodName);
        if ($setAccessible) {
            $method->setAccessible(true);
        }

        return $method;
    }

    /**
     * @param string $className
     * @return string[]
     */
    public static function getMethodNames($className)
    {
        return array_map(
            function (\ReflectionMethod $method) {
                return $method->getName();
            },
            self::getReflectionClass($className)->getMethods()
        );
    }

    /**
     * @param string $className
     * @return array
     */
    public static function getPropertyNames($className)
    {
        return array_map(
            function (\ReflectionProperty $property) {
                return $property->getName();
            },
            self::getReflectionClass($className)->getProperties()
        );
    }
}
