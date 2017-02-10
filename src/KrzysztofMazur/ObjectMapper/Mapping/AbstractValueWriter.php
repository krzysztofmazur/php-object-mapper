<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;
use KrzysztofMazur\ObjectMapper\Exception\NullSourceException;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\ReferenceGetterInterface;

abstract class AbstractValueWriter implements ValueWriterInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var ReferenceGetterInterface
     */
    protected $referenceGetter;

    /**
     * @param string                   $className
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct($className, ReferenceGetterInterface $referenceGetter = null)
    {
        $this->className = $className;
        $this->referenceGetter = $referenceGetter;
    }

    /**
     * {@inheritdoc}
     */
    public function write($object, $value)
    {
        if (is_null($object)) {
            throw new NullSourceException();
        }
        if (get_class($object) !== $this->className) {
            throw new NotSupportedMappingException(get_class($object));
        }
        $reference = $object;
        if (!is_null($this->referenceGetter)) {
            $reference = $this->referenceGetter->getReference($reference);
        }

        $this->writeValue($reference, $value);
    }

    /**
     * @param mixed $object
     * @param mixed $value
     * @return mixed
     */
    abstract protected function writeValue($object, $value);

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
