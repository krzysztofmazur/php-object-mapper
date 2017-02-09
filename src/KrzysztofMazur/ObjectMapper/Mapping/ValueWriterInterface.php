<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

interface ValueWriterInterface
{
    /**
     * @param mixed $object
     * @param mixed $value
     * @return void
     */
    public function write($object, $value);
}
