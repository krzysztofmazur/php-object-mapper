<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

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
     * @return ValueReaderInterface
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * {@inheritdoc}
     */
    public function read($object)
    {
        if (is_null($object)) {
            throw new \InvalidArgumentException("Unexpected null value");
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
