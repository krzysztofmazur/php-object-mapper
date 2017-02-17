<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
     * @param string               $methodName
     * @param array                $arguments
     * @param ValueReaderInterface $next
     */
    public function __construct($methodName, $arguments = [], ValueReaderInterface $next = null)
    {
        parent::__construct($next);
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
    {
        return Reflection::getMethod(get_class($object), $this->methodName)
            ->invokeArgs($object, $this->arguments);
    }
}
