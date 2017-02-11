<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NullReferenceException;
use KrzysztofMazur\ObjectMapper\Mapping\ValueWriter\ReferenceGetterInterface;

abstract class AbstractValueWriter implements ValueWriterInterface
{
    /**
     * @var ReferenceGetterInterface
     */
    protected $referenceGetter;

    /**
     * @param ReferenceGetterInterface $referenceGetter
     */
    public function __construct(ReferenceGetterInterface $referenceGetter = null)
    {
        $this->referenceGetter = $referenceGetter;
    }

    /**
     * @return ReferenceGetterInterface
     */
    public function getReferenceGetter()
    {
        return $this->referenceGetter;
    }

    /**
     * {@inheritdoc}
     */
    public function write($object, $value)
    {
        if (is_null($object)) {
            throw new NullReferenceException();
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
}
