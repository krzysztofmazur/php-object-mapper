<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

class Field implements FieldInterface
{
    /**
     * @var ValueReaderInterface
     */
    private $reader;

    /**
     * @var ValueWriterInterface
     */
    private $writer;

    /**
     * @param ValueReaderInterface $reader
     * @param ValueWriterInterface $writer
     */
    public function __construct(ValueReaderInterface $reader, ValueWriterInterface $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @return ValueReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @return ValueWriterInterface
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * {@inheritdoc}
     */
    public function map($source, $target)
    {
        $value = $this->reader->read($source);
        $this->writer->write($target, $value);
    }
}
