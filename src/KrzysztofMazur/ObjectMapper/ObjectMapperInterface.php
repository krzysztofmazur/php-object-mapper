<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
interface ObjectMapperInterface
{
    /**
     * @param mixed  $source
     * @param string $targetClass
     * @param string $mapId
     * @return mixed
     * @throws MappingException
     */
    public function map($source, $targetClass, $mapId = null);

    /**
     * @param mixed  $source
     * @param mixed  $target
     * @param string $mapId
     * @return mixed
     * @throws MappingException
     */
    public function mapToObject($source, $target, $mapId = null);
}
