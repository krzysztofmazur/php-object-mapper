<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\ReferenceGetterInterface;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

class MethodValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $methodName;

    /**
     * @param string                   $methodName
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct($methodName, ReferenceGetterInterface $referenceGetter = null)
    {
        parent::__construct($referenceGetter);
        $this->methodName = $methodName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        Reflection::getMethod(get_class($object), $this->methodName, true)->invokeArgs($object, [$value]);
    }
}
