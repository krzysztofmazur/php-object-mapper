<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

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
     * @param string                   $methodName
     * @param array                    $arguments
     * @param ReferenceGetterInterface $next
     */
    public function __construct($methodName, $arguments = [], ReferenceGetterInterface $next = null)
    {
        parent::__construct($next);
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReferenceInternal($object)
    {
        return Reflection::getMethod(get_class($object), $this->methodName)
            ->invokeArgs($object, $this->arguments);
    }
}
