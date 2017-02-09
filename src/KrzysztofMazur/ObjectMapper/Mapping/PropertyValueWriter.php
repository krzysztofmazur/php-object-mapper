<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;

class PropertyValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string $className
     * @param string $propertyName
     */
    public function __construct($className, $propertyName)
    {
        parent::__construct($className);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasProperty($this->propertyName)) {
            throw new PropertyNotFoundException(
                sprintf("Class \"%s\" doesn't have property \"%s\"", $reflectionClass->name, $this->propertyName)
            );
        }

        $property = $this->getReflectionClass()->getProperty($this->propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }
}
