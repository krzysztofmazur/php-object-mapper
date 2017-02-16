<?php

namespace Tests\KrzysztofMazur\ObjectMapper\Mapping;

use KrzysztofMazur\ObjectMapper\Mapping\Field\ValueReader\ValueInitializer;
use KrzysztofMazur\ObjectMapper\Util\InitializerInterface;
use PHPUnit\Framework\TestCase;
use TestFixtures\SimpleObject;

class ValueInitializerTest extends TestCase
{
    /**
     * @var InitializerInterface
     */
    private $initializerMock;

    public function setUp()
    {
        $this->initializerMock = $this->createMock(InitializerInterface::class);
    }

    public function testInitializeSuccess()
    {
        $this->initializerMock->method('initialize')->willReturn(new SimpleObject());
        $valueInitializer = new ValueInitializer(SimpleObject::class, $this->initializerMock);
        $object = $valueInitializer->read(null);

        self::assertInstanceOf(SimpleObject::class, $object);
    }
}
