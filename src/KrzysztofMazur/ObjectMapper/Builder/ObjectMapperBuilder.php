<?php

namespace KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepositoryInterface;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperBuilder extends AbstractBuilder
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
     * @return ObjectMapperBuilder
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param InitializerInterface $initializer
     * @return $this
     */
    public function setInitializer(InitializerInterface $initializer)
    {
        $this->initializer = $initializer;

        return $this;
    }

    /**
     * @param MappingRepositoryInterface $repository
     * @return $this
     */
    public function setRepository(MappingRepositoryInterface $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return ObjectMapper
     */
    public function build()
    {
        self::assertNotNull($this->initializer, 'Initializer should be provided');
        self::assertNotNull($this->repository, 'Mapping repository should be provided');

        return new ObjectMapper($this->initializer, $this->repository);
    }
}
