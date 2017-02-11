<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;

interface MappingRepositoryInterface
{
    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @param string $mapId
     * @return Mapping
     * @throws NotSupportedMappingException
     */
    public function getMapping($sourceClass, $targetClass, $mapId = null);
}
