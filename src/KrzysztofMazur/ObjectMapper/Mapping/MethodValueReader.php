<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;

class MethodValueReader extends AbstractValueReader
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
     * @param string               $className
     * @param string               $methodName
     * @param array                $arguments
     * @param ValueReaderInterface $next
     */
    public function __construct($className, $methodName, $arguments = [], ValueReaderInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
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
