<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\ReferenceGetterInterface;

class MethodValueWriter extends AbstractValueWriter
{
    /**
     * @var string
     */
    private $methodName;

    /**
     * @param string                   $className
     * @param string                   $methodName
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct($className, $methodName, ReferenceGetterInterface $referenceGetter = null)
    {
        parent::__construct($className, $referenceGetter);
        $this->methodName = $methodName;
    }

    /**
     * {@inheritdoc}
     */
    protected function writeValue($object, $value)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasMethod($this->methodName)) {
            throw new MethodNotFoundException(
                sprintf("Class \"%s\" doesn't have method \"%s\"", $reflectionClass->name, $this->methodName)
            );
        }

        $method = $reflectionClass->getMethod($this->methodName);
        $method->setAccessible(true);
        $method->invokeArgs($object, [$value]);
    }
}
