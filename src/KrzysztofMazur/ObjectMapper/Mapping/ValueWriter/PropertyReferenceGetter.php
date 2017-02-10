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
     * @param string                   $propertyName
     * @param ReferenceGetterInterface $next
     */
    public function __construct($propertyName, ReferenceGetterInterface $next = null)
    {
        parent::__construct($next);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferenceInternal($object)
    {
        return Reflection::getProperty(get_class($object), $this->propertyName, true)->getValue($object);
    }
}
