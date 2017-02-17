<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueReaderInterface;
use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter\ValueWriterInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
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
        $this->writer->write($target, $this->reader->read($source));
    }
}
