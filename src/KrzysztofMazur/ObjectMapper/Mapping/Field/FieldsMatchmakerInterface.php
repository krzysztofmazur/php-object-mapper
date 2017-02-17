<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface FieldsMatchmakerInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return array
     */
    public function match($sourceClass, $targetClass);
}
