<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;

class MethodReferenceGetter extends AbstractReferenceGetter
{
    /**
     * @var string
     */
    private $methodName;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param string                   $className
     * @param string                   $methodName
     * @param array                    $arguments
     * @param ReferenceGetterInterface $next
     */
    public function __construct($className, $methodName, $arguments = [], ReferenceGetterInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferenceInternal($object)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasMethod($this->methodName)) {
            throw new MethodNotFoundException($reflectionClass->name, $this->methodName);
        }

        $method = $reflectionClass->getMethod($this->methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $this->arguments);
    }
}
