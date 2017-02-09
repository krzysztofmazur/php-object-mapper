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
     * @param string               $className
     * @param string               $methodName
     * @param ValueReaderInterface $next
     */
    public function __construct($className, $methodName, ValueReaderInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->methodName = $methodName;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
    {
        $reflectionClass = $this->getReflectionClass();
        if (!$reflectionClass->hasMethod($this->methodName)) {
            throw new MethodNotFoundException(
                sprintf("Class \"%s\" doesn't have method \"%s\"", $reflectionClass->name, $this->methodName)
            );
        }

        $method = $reflectionClass->getMethod($this->methodName);
        $method->setAccessible(true);

        return $method->invoke($object);
    }
}
