<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\ReferenceGetterInterface;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

class PropertyValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string                   $className
     * @param string                   $propertyName
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct($className, $propertyName, ReferenceGetterInterface $referenceGetter = null)
    {
        parent::__construct($className, $referenceGetter);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        Reflection::getProperty($this->getClassName(), $this->propertyName, true)->setValue($object, $value);
    }
}
