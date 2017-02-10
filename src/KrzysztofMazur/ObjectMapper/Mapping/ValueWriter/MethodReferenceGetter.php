<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\ValueWriter;

use KrzysztofMazur\ObjectMapper\Exception\MethodNotFoundException;
use KrzysztofMazur\ObjectMapper\Util\Reflection;

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
        return Reflection::getMethod($this->getClassName(), $this->methodName, true)
            ->invokeArgs($object, $this->arguments);
    }
}
