<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Builder;

use KrzysztofMazur\ObjectMapper\Builder\ObjectMapperSimpleBuilder;
use KrzysztofMazur\ObjectMapper\ObjectMapper;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Krzysztof Mazur <krz@ychu.pl>
 */
class ObjectMapperSimpleBuilderTest extends TestCase
{
    public function testBuildSuccess()
    {
        $mapper = ObjectMapperSimpleBuilder::create()
            ->setConfig([])
            ->setInitializer($this->createMock(InitializerInterface::class))
            ->build();

        self::assertInstanceOf(ObjectMapper::class, $mapper);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildFail()
    {
        ObjectMapperSimpleBuilder::create()->build();
    }
}
