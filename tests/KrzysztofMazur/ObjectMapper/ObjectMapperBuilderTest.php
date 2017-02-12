<?php

namespace Tests\KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\ObjectMapperBuilder;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;

class ObjectMapperBuilderTest extends TestCase
{
    public function testSuccess()
    {
        $initializer = $this->createMock(InitializerInterface::class);
        $repository = $this->createMock(MappingRepository::class);

        $mapper = ObjectMapperBuilder::getInstance()
            ->setInitializer($initializer)
            ->setRepository($repository)
            ->build();

        self::assertInstanceOf(ObjectMapper::class, $mapper);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        ObjectMapperBuilder::getInstance()->build();
    }
}
