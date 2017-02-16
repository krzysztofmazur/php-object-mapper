<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface ValueReaderInterface
{
    /**
     * @param mixed $object
     * @return mixed
     * @throws MappingException
     */
    public function read($object);
}