<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;

interface MappingRepositoryInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @param string $mapId
     * @return Mapping
     * @throws MappingException
     */
    public function getMapping($sourceClass, $targetClass, $mapId = null);
}
