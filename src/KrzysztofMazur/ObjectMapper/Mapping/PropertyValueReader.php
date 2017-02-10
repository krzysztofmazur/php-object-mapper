<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Util\Reflection;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class PropertyValueReader extends AbstractValueReader
{
    /**
     * @var string
     */
    private $propertyName;

    /**
     * @param string               $className
     * @param string               $propertyName
     * @param ValueReaderInterface $next
     */
    public function __construct($className, $propertyName, ValueReaderInterface $next = null)
    {
        parent::__construct($className, $next);
        $this->propertyName = $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    protected function readValue($object)
    {
        return Reflection::getProperty($this->getClassName(), $this->propertyName, true)->getValue($object);
    }
}
