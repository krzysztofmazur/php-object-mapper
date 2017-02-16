<?php

namespace KrzysztofMazur\ObjectMapper\Util;

class Reflection
{
    /**
     * @var array
     */
    private static $reflectionClasses = [];

    /**
     * @var array
     */
    private static $reflectionProperties = [];

    /**
     * @var array
     */
    private static $reflectionMethods = [];

    /**
     * @var array
     */
    private static $classProperties = [];

    /**
     * @var array
     */
    private static $classMethods = [];

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
        if (!isset(self::$reflectionClasses[$className])) {
            self::$reflectionClasses[$className] = new \ReflectionClass($className);
        }

        return self::$reflectionClasses[$className];
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    public static function getProperty($className, $propertyName)
    {
        $key = sprintf("%s->%s", $className, $propertyName);
        if (!isset(self::$reflectionProperties[$key])) {
            $property = self::getReflectionClass($className)->getProperty($propertyName);
            $property->setAccessible(true);
            self::$reflectionProperties[$key] = $property;
        }

        return self::$reflectionProperties[$key];
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    public static function getMethod($className, $methodName)
    {
        $key = sprintf("%s->%s", $className, $methodName);
        if (!isset(self::$reflectionMethods[$key])) {
            $method = self::getReflectionClass($className)->getMethod($methodName);
            $method->setAccessible(true);
            self::$reflectionMethods[$key] = $method;
        }

        return self::$reflectionMethods[$key];
    }

    /**
     * @param string $className
     * @return string[]
     */
    public static function getMethodNames($className)
    {
        if (!isset(self::$classMethods[$className])) {
            self::$classMethods[$className] = array_map(
                function (\ReflectionMethod $method) {
                    return $method->getName();
                },
                self::getReflectionClass($className)->getMethods()
            );
        }

        return self::$classMethods[$className];
    }

    /**
     * @param string $className
     * @return array
     */
    public static function getPropertyNames($className)
    {
        if (!isset(self::$classProperties[$className])) {
            self::$classProperties[$className] = array_map(
                function (\ReflectionProperty $property) {
                    return $property->getName();
                },
                self::getReflectionClass($className)->getProperties()
            );
        }

        return self::$classProperties[$className];
    }
}
