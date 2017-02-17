<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueWriter;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface ValueWriterInterface
{
    /**
     * @param mixed $object
     * @param mixed $value
     * @return void
     */
    public function write($object, $value);
}
