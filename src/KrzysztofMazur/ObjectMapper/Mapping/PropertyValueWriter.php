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
     * @param string                   $propertyName
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct($propertyName, ReferenceGetterInterface $referenceGetter = null)
    {
        parent::__construct($referenceGetter);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        Reflection::getProperty(get_class($object), $this->propertyName, true)->setValue($object, $value);
    }
}
