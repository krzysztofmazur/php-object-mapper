<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

class FieldsAutoDetector implements FieldsAutoDetectorInterface
{
    const GETTER_PATTERN = '/^(is|get)(.*)$/';

    /**
     * {@inheritdoc}
     */
    public function detect($sourceClass, $targetClass)
    {
        $fields = [];
        $targetClassProperties = Reflection::getPropertyNames($targetClass);
        $sourceClassProperties = Reflection::getPropertyNames($sourceClass);
        foreach ($targetClassProperties as $targetClassProperty) {
            if (in_array($targetClassProperty, $sourceClassProperties)) {
                $fields[$targetClassProperty] = $targetClassProperty;
            }
        }
        $parsedGetters = $this->parseGetters($this->getClassGetters($sourceClass));
        foreach ($parsedGetters as $parsedGetter) {

        }
    }

    /**
     * @param string $className
     * @return array
     */
    private function getClassGetters($className)
    {
        return array_filter(
            Reflection::getMethodNames($className),
            function ($methodName) {
                return preg_match(self::GETTER_PATTERN, $methodName);
            }
        );
    }

    /**
     * @param array $getters
     * @return array
     */
    private function parseGetters(array $getters)
    {
        $result = [];
        foreach ($getters as $getter) {
            $result[$this->parseGetterMethodName($getter)] = $getter;
        }

        return $result;
    }

    /**
     * @param string $getter
     * @return string
     */
    private function parseGetterMethodName($getter)
    {

    }
}
