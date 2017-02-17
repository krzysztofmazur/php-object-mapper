<?php

namespace KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Exception\MappingException;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmakerInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class MappingRepository implements MappingRepositoryInterface
{
    /**
     * @var array
     */
    private $mappings;

    /**
     * @param array                     $config
     * @param FieldFactory              $fieldFactory
     * @param FieldsMatchmakerInterface $fieldsMatchmaker
     */
    public function __construct(array $config, FieldFactory $fieldFactory, FieldsMatchmakerInterface $fieldsMatchmaker)
    {
        $this->mappings = [];
        foreach ($config as $mappingConfiguration) {
            self::checkMappingConfiguration($mappingConfiguration);
            $mapId = isset($mappingConfiguration['mapId']) ? $mappingConfiguration['mapId'] : null;
            if (!isset($this->mappings[$mapId])) {
                $this->mappings[$mapId] = [];
            }
            $auto = isset($mappingConfiguration['auto']) ? $mappingConfiguration['auto'] : false;
            $this->mappings[$mapId][] = MappingBuilder::getInstance()
                ->setFields($mappingConfiguration['fields'])
                ->setSourceClass($mappingConfiguration['from'])
                ->setTargetClass($mappingConfiguration['to'])
                ->setFieldFactory($fieldFactory)
                ->setFieldsAutoMatch($auto)
                ->setFieldsMatchmaker($fieldsMatchmaker)
                ->build();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMapping($sourceClass, $targetClass, $mapId = null)
    {
        if (!isset($this->mappings[$mapId])) {
            throw MappingException::createNotSupportedMapping($sourceClass, $targetClass);
        }
        foreach ($this->mappings[$mapId] as $mapping) {
            /** @var Mapping $mapping */
            if ($mapping->supports($sourceClass, $targetClass)) {
                return $mapping;
            }
        }

        throw MappingException::createNotSupportedMapping($sourceClass, $targetClass);
    }

    /**
     * @param array $configuration
     */
    private static function checkMappingConfiguration(array $configuration)
    {
        self::assertOneOfArrayKeysExist(
            ['fields', 'auto'],
            $configuration,
            "\"fields\" or \"auto\" property is required"
        );
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

    /**
     * @param string[] $keys
     * @param array    $array
     * @param string   $message
     */
    private static function assertOneOfArrayKeysExist($keys, $array, $message)
    {
        foreach ($keys as $key) {
            if (isset($array[$key])) {
                return;
            }
        }

        throw new \InvalidArgumentException($message);
    }
}
