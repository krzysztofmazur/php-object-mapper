<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

class FieldsMatchmaker implements FieldsMatchmakerInterface
{
    const GETTER_PATTERN = '/^(is|get)(.*)$/';

    /**
     * @var PropertyNameConverterInterface
     */
    private $converter;

    /**
     * @param PropertyNameConverterInterface $converter
     */
    public function __construct(PropertyNameConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * {@inheritdoc}
     */
    public function match($sourceClass, $targetClass)
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
        foreach ($parsedGetters as $property => $getter) {
            if (isset($fields[$property])) {
                continue;
            }
            if (in_array($property, $targetClassProperties)) {
                $fields[$property] = sprintf("%s()", $getter);
            }
        }

        return $fields;
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
            $result[$this->converter->getPropertyName($getter)] = $getter;
        }

        return $result;
    }
}
