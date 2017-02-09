<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;
use KrzysztofMazur\ObjectMapper\Exception\NullSourceException;

abstract class AbstractValueWriter implements ValueWriterInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function write($object, $value)
    {
        if (is_null($object)) {
            throw new NullSourceException("Passed object is null");
        }
        if (get_class($object) !== $this->className) {
            throw new NotSupportedMappingException(sprintf("Class \"%s\" is not supported", get_class($object)));
        }
        $this->writeValue($object, $value);
    }

    /**
     * @param mixed $object
     * @param mixed $value
     * @return mixed
     */
    abstract protected function writeValue($object, $value);

    /**
     * @return \ReflectionClass
     */
    protected function getReflectionClass()
    {
        return new \ReflectionClass($this->className);
    }
}
