<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;
use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapper implements ObjectMapperInterface
{
    /**
     * @var InitializerInterface
     */
    private $initializer;

    /**
     * @var array
     */
    private $mappings;

    /**
     * @param InitializerInterface $initializer
     */
    public function __construct(InitializerInterface $initializer)
    {
        $this->initializer = $initializer;
        $this->mappings = [];
    }

    /**
     * @param Mapping $mapping
     * @param string  $mapId
     */
    public function addMapping(Mapping $mapping, $mapId = null)
    {
        if (!array_key_exists($mapId, $this->mappings)) {
            $this->mappings[$mapId] = [];
        }
        $this->mappings[$mapId][] = $mapping;
    }

    /**
     * {@inheritdoc}
     */
    public function map($source, $targetClass, $mapId = null)
    {
        $object = $this->initializer->initialize($targetClass);
        $this->mapToObject($source, $object, $mapId);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function mapToObject($source, $target, $mapId = null)
    {
        $this->getMapping(get_class($source), get_class($target), $mapId)->map($source, $target);

        return $target;
    }

    /**
     * @param string $sourceClass
     * @param string $targetClass
     * @param string $mapId
     * @return Mapping
     * @throws NotSupportedMappingException
     */
    private function getMapping($sourceClass, $targetClass, $mapId = null)
    {
        if (!array_key_exists($mapId, $this->mappings)) {
            throw new NotSupportedMappingException($sourceClass, $targetClass);
        }
        foreach ($this->mappings[$mapId] as $mapping) {
            /** @var Mapping $mapping */
            if ($mapping->supports($sourceClass, $targetClass)) {
                return $mapping;
            }
        }

        throw new NotSupportedMappingException($sourceClass, $targetClass);
    }
}
