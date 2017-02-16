<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

interface ValueWriterInterface
{
    /**
     * @param mixed $object
     * @param mixed $value
     * @return void
     */
    public function write($object, $value);
}
