<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepositoryInterface;
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
     * @var MappingRepositoryInterface
     */
    private $repository;

    /**
     * @param InitializerInterface       $initializer
     * @param MappingRepositoryInterface $mappingRepository
     */
    public function __construct(InitializerInterface $initializer, MappingRepositoryInterface $mappingRepository)
    {
        $this->initializer = $initializer;
        $this->repository = $mappingRepository;
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
        $this->repository->getMapping(get_class($source), get_class($target), $mapId)->map($source, $target);

        return $target;
    }
}
