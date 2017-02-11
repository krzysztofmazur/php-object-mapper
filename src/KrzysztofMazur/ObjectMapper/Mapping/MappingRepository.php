<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Builder\FieldFactory;
use KrzysztofMazur\ObjectMapper\Builder\MappingBuilder;
use KrzysztofMazur\ObjectMapper\Exception\NotSupportedMappingException;

class MappingRepository implements MappingRepositoryInterface
{
    /**
     * @var array
     */
    private $mappings;

    /**
     * @param array        $config
     * @param FieldFactory $fieldFactory
     */
    public function __construct(array $config, FieldFactory $fieldFactory)
    {
        $this->mappings = [];
        foreach ($config as $mappingConfiguration) {
            $mapId = isset($mappingConfiguration['mapId']) ? $mappingConfiguration['mapId'] : null;
            if (!array_key_exists($mapId, $this->mappings)) {
                $this->mappings[$mapId] = [];
            }
            $this->mappings[$mapId][] = MappingBuilder::getInstance()
                ->setFields($mappingConfiguration['fields'])
                ->setSourceClass($mappingConfiguration['from'])
                ->setTargetClass($mappingConfiguration['to'])
                ->setFieldFactory($fieldFactory)
                ->build();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMapping($sourceClass, $targetClass, $mapId = null)
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
