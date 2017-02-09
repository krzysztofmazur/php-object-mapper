<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Exception\PropertyNotFoundException;

class PropertyReferenceGetter extends AbstractReferenceGetter
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string                   $className
     * @param string                   $propertyName
     * @param ReferenceGetterInterface $next
     */
    public function __construct($className, $propertyName, ReferenceGetterInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferenceInternal($object)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasProperty($this->propertyName)) {
            throw new PropertyNotFoundException(
                sprintf("Class \"%s\" doesn't have property \"%s\"", $reflectionClass->name, $this->propertyName)
            );
        }

        $property = $reflectionClass->getProperty($this->propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
