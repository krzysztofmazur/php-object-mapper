<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

interface FieldsMatchmakerInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return array
     */
    public function detect($sourceClass, $targetClass);
}
