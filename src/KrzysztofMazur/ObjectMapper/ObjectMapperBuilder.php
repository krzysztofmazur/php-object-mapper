<?php

namespace KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepositoryInterface;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;

class ObjectMapperBuilder
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
     *
     * @codeCoverageIgnore
     */
    public static function getInstance()
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

    /**
     * @param mixed  $arg
     * @param string $message
     */
    private static function assertNotNull($arg, $message)
    {
        if (is_null($arg)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
