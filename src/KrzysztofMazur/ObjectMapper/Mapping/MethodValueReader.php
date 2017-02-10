<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

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
        return Reflection::getMethod($this->getClassName(), $this->methodName, true)
            ->invokeArgs($object, $this->arguments);
    }
}
