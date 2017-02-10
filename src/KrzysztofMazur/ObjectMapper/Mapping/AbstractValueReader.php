<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NullReferenceException;

abstract class AbstractValueReader implements ValueReaderInterface
{
    /**
     * @var ValueReaderInterface
     */
    private $next;

    /**
     * @param ValueReaderInterface $next
     */
    public function __construct(ValueReaderInterface $next = null)
    {
        $this->next = $next;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        if (is_null($object)) {
            throw new NullReferenceException();
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
}
