<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

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
        return Reflection::getProperty($this->getClassName(), $this->propertyName, true)->getValue($object);
    }
}
