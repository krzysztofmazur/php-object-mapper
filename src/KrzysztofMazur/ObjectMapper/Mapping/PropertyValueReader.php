<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class PropertyValueReader extends AbstractValueReader
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string               $className
     * @param string               $propertyName
     * @param ValueReaderInterface $next
     */
    public function __construct($className, $propertyName, ValueReaderInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasProperty($this->propertyName)) {
            throw new PropertyNotFoundException($reflectionClass->name, $this->propertyName);
        }

        $property = $reflectionClass->getProperty($this->propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
