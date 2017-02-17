<?php

namespace Tests\KrzysztofMazur\ObjectMapper;

use KrzysztofMazur\ObjectMapper\Mapping\Mapping;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperTest extends TestCase
{
    public function testMapSuccess()
    {
        $source = $this->createMock(SimpleObject::class);
        $target = $this->createMock(SimpleObject::class);

        $initializer = $this->createMock(InitializerInterface::class);
        $initializer
            ->expects(self::once())
            ->method('initialize')
            ->with(self::equalTo(SimpleObject::class))
            ->willReturn($target);

        $mapping = $this->createMock(Mapping::class);
        $mapping
            ->expects(self::once())
            ->method('map')
            ->with(self::equalTo($source), self::equalTo($target))
            ->willReturn(null);

        $repository = $this->createMock(MappingRepository::class);
        $repository
            ->expects(self::once())
            ->method('getMapping')
            ->with(get_class($source), get_class($target))
            ->willReturn($mapping);

        $mapper = new ObjectMapper($initializer, $repository);
        $mapper->map($source, SimpleObject::class);
    }
}
