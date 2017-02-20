<?php
/*
 * This file is part of php-object-mapper.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverterInterface;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
        $this->matchProperties($fields, $targetClassProperties, $sourceClassProperties);
        $this->matchAccessors($fields, $targetClassProperties, $sourceClass);

        return $fields;
    }

    /**
     * @param array $fields
     * @param array $targetClassProperties
     * @param array $sourceClassProperties
     */
    private function matchProperties(&$fields, $targetClassProperties, $sourceClassProperties)
    {
        foreach ($targetClassProperties as $targetClassProperty) {
            if (in_array($targetClassProperty, $sourceClassProperties)) {
                $fields[$targetClassProperty] = $targetClassProperty;
            }
        }
    }

    /**
     * @param array  $fields
     * @param array  $targetClassProperties
     * @param string $sourceClass
     */
    private function matchAccessors(&$fields, $targetClassProperties, $sourceClass)
    {
        $parsedGetters = $this->parseGetters($this->getClassGetters($sourceClass));
        foreach ($parsedGetters as $property => $getter) {
            if (isset($fields[$property])) {
                continue;
            }
            if (in_array($property, $targetClassProperties)) {
                $fields[$property] = sprintf("%s()", $getter);
            }
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
            $result[$this->converter->getPropertyName($getter)] = $getter;
        }

        return $result;
    }
}
