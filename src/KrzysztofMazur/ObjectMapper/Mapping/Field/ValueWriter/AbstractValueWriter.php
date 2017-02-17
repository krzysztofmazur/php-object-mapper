<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueReaderInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
abstract class AbstractValueWriter implements ValueWriterInterface
{
    /**
     * @var ValueReaderInterface
     */
    protected $valueReader;

    /**
     * @param ValueReaderInterface $valueReader
     */
    public function __construct(ValueReaderInterface $valueReader = null)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @return ValueReaderInterface
     */
    public function getValueReader()
    {
        return $this->valueReader;
    }

    /**
     * {@inheritdoc}
     */
    public function write($object, $value)
    {
        if (is_null($object)) {
            throw new \InvalidArgumentException("Unexpected null value");
        }
        $reference = $object;
        if (!is_null($this->valueReader)) {
            $reference = $this->valueReader->read($reference);
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
