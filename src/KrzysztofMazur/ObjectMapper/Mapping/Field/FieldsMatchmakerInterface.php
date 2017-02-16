<?php

namespace KrzysztofMazur\ObjectMapper\Mapping\Field;

interface FieldsMatchmakerInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return array
     */
    public function match($sourceClass, $targetClass);
}
