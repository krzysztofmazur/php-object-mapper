<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface FieldInterface
{
    /**
     * @param mixed $source
     * @param mixed $target
     */
    public function map($source, $target);
}
