<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

interface FieldsAutoDetectorInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @return array
     */
    public function detect($sourceClass, $targetClass);
}
