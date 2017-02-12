<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\MappingBuilder;
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
            self::checkMappingConfiguration($mappingConfiguration);
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

    /**
     * @param array $configuration
     */
    private static function checkMappingConfiguration(array $configuration)
    {
        self::assertArrayKeyExists('fields', $configuration, "Missing \"fields\" key in mapping configuration");
        self::assertArrayKeyExists('from', $configuration, "Missing \"from\" key in mapping configuration");
        self::assertArrayKeyExists('to', $configuration, "Missing \"to\" key in mapping configuration");
    }

    /**
     * @param string $key
     * @param array  $array
     * @param string $message
     */
    private static function assertArrayKeyExists($key, $array, $message)
    {
        if (!isset($array[$key])) {
            throw new \InvalidArgumentException($message);
        }
    }
}