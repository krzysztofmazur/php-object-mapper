<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;

interface ObjectMapperInterface
{
    /**
     * @param mixed  $source
     * @param string $destinationClass
     * @param string $mapId
     * @return mixed
     * @throws MappingException
     */
    public function map($source, $destinationClass, $mapId = null);

    /**
     * @param mixed  $source
     * @param mixed $destination
     * @param string $mapId
     * @return mixed
     * @throws MappingException
     */
    public function mapToObject($source, $destination, $mapId = null);
}
