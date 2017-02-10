<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;
use KrzysztofMazur\ObjectMapper\Exception\NullSourceException;

abstract class AbstractValueReader implements ValueReaderInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var ValueReaderInterface
     */
    private $next;

    /**
     * @param string               $className
     * @param ValueReaderInterface $next
     */
    public function __construct($className, ValueReaderInterface $next = null)
    {
        $this->className = $className;
        $this->next = $next;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        if (is_null($object)) {
            throw new NullSourceException();
        }
        if (get_class($object) !== $this->className) {
            throw new NotSupportedMappingException(get_class($object));
        }
        $value = $this->readValue($object);
        if (!is_null($this->next)) {
            $value = $this->next->read($value);
        }

        return $value;
    }

    /**
     * @param mixed $object
     * @return mixed
     */
    abstract protected function readValue($object);

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->className;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getReflectionClass()
    {
        return new \ReflectionClass($this->className);
    }
}
